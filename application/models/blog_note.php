<?php defined('SYSPATH') or die('No direct script access.');

class Blog_note_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }

    public function get_list()
    {
	$list = $this->cache->get('blog_note_get_list');
	if (!$list)
	{
	    $result = Database::instance()->query('SELECT title, name FROM blog_notes WHERE visible=1 ORDER BY date DESC LIMIT 0,10');
	    $list = array();
	    foreach ($result as $item)
		$list[]=$item;
	    $this->cache->set('blog_note_get_list',$list);
	}
	return $list;
    }

    private function get_note_photos($id)
    {
	$photos = array();
	$result = Database::instance()->query('SELECT title, url FROM blog_photos WHERE note_id=?',$id);
	foreach ($result as $photo)
	    $photos[]=$photo;
	return $photos;
    }

    private function get_note_files($id)
    {
	$files = array();
	$result = Database::instance()->query('SELECT title, url FROM blog_files WHERE note_id=?',$id);
	foreach ($result as $file)
	    $files[]=$file;
	return $files;
    }

    private function get_note_categories($id)
    {
	$categories = array();
	$result = Database::instance()->query('SELECT 
	    c.title,
	    c.name
	    FROM blog_categories c, blog_notes_categories nc WHERE c.visible=1 AND nc.category_id=c.id AND nc.note_id=?',$id);
	foreach ($result as $category)
	    $categories[]=$category;
	return $categories;
    }

    private function get_note_tags($id)
    {
	$categories = array();
	$result = Database::instance()->query('SELECT 
	    c.title,
	    c.name
	    FROM blog_tags c, blog_notes_tags nc WHERE nc.tag_id=c.id AND nc.note_id=? ORDER BY c.title ASC',$id);
	foreach ($result as $category)
	    $categories[]=$category;
	return $categories;
    }

    private function get_note_comments($id)
    {
	$comments = array();

	$result = Database::instance()->query('SELECT * FROM blog_comments WHERE note_id=? ORDER BY `date` ASC',$id);
	foreach ($result as $comment)
	    $comments[]=$comment;
	return $comments;
    }

    public function get_note($id)
    {
	if (!is_numeric($id))
	{
	    $query = Database::instance()->query('SELECT id FROM blog_notes WHERE name=?',$id,$id);
	    if (count($query)==0)
		return 0;
	    $id = $query[0]->id;
	}

	$note = $this->cache->get('blog_note_get_note_'.$id);
	if (!$note)
	{
	    $query = Database::instance()->query('SELECT 
		title,
		name,
		`text`,
		description,
		(rating/rating_count) as rating,
		`date`
		FROM blog_notes WHERE id=?',$id);
		
	    if (count($query)==0)
		return 0;

	    $note = $query[0];
	    $note->id = $id;
	    require_once Kohana::find_file('vendor','Markdown');
	    $note->text = markdown($note->text);
	    $note->rating = round($note->rating);
	    
	    $note->photos = $this->get_note_photos($id);
	    $note->files = $this->get_note_files($id);
	    $note->categories = $this->get_note_categories($id);
	    $note->tags = $this->get_note_tags($id);

	    $this->cache->set('blog_note_get_note_'.$id,$note);
	}
	$note->count_comments = $this->count_comments($id);
	$note->comments = $this->get_note_comments($id);
	return (object)$note;
    }

    public function get_notes($category=NULL, $page = 1, $per_page = 6, $mode = 1)
    {
	$notes = array();

	if ($mode==1)
	{
	    $where = '';
	    if ($category)
		$where = ' AND (c.name="'.$category.'")';

	    $result = Database::instance()->query('SELECT n.id FROM blog_notes n, blog_categories c, blog_notes_categories nc WHERE n.visible=1 AND n.id=nc.note_id AND c.id=nc.category_id'.$where.' ORDER BY date DESC LIMIT ?,?', ($page-1)*$per_page, $per_page);
	    foreach ($result as $item)
		$notes[] = $this->get_note($item->id);
	}
	if ($mode==2)
	{
	    $result = Database::instance()->query('SELECT n.id FROM blog_notes n, blog_categories c, blog_notes_categories nc, blog_tags t, blog_notes_tags nt WHERE nt.note_id=n.id AND nt.tag_id=t.id AND n.visible=1 AND n.id=nc.note_id AND c.id=nc.category_id AND (t.name=?) ORDER BY date DESC LIMIT ?,?',$category, ($page-1)*$per_page, $per_page);
	    foreach ($result as $item)
		$notes[] = $this->get_note($item->id);
	}
	return $notes;
    }

    public function count_notes($category=NULL,$mode=1)
    {
	$where = '';
	$count = 0;
	if ($mode==1)
	{
	    if ($category)
		$where = ' AND (c.name="'.$category.'")';
	    $result = Database::instance()->query('SELECT COUNT(*) as count FROM blog_categories c, blog_notes_categories nc, blog_notes n WHERE n.visible=1 AND n.id=nc.note_id AND c.id=nc.category_id'.$where);
	    $count = $result[0]->count;
	}
	if ($mode==2)
	{
	    $result = Database::instance()->query('SELECT COUNT(*) as count FROM blog_categories c, blog_notes_categories nc, blog_notes n, blog_tags t, blog_notes_tags nt WHERE t.id=nt.tag_id AND nt.note_id=n.id AND (t.name=?) AND n.visible=1 AND n.id=nc.note_id AND c.id=nc.category_id',$category,$category);
	    $count = $result[0]->count;
	}
	return $count;
    }

    public function count_comments($id)
    {
	$result = Database::instance()->query('SELECT COUNT(*) as count FROM blog_comments WHERE active=1 AND note_id=?',$id);
	$count = $result[0]->count;
	return $count;
    }
} 
