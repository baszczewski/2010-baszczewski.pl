<?php defined('SYSPATH') or die('No direct script access.');

class Cms_page_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }

    public function get_list($id)
    {
	$list = $this->cache->get('cms_page_get_list_'.$id);
	if (!$list)
	{
	    $list = array();
	    $result = Database::instance()->query('SELECT 
	    title, 
	    name, 
	    url FROM cms_pages WHERE visible=1 AND category_id=? ORDER BY `order` ASC',$id);
	    foreach ($result as $item)
		$list[]=$item;

	    $this->cache->set('cms_page_get_list_'.$id, $list);
	}
	return $list;
    }

    public function get_page($id)
    {
	if (!is_numeric($id))
	{
	    $result = Database::instance()->query('SELECT id FROM cms_pages WHERE name=?',$id,$id);
	    if (count($result)==0)
		return 0;
	    $id = $result[0]->id;
	}

	$page = $this->cache->get('cms_page_get_page_'.$id);
	if (!$page) 
	{
	    $result = Database::instance()->query('SELECT 
		title,
		name,
		`text`,
		description,
		keywords,
		background
		FROM cms_pages WHERE visible=1 AND id=?',$id);
	    
	    if (count($result)==0)
		return 0;
		
	    $page = $result[0];
	    require Kohana::find_file('vendor','Markdown');
	    $page->text = markdown($page->text);
	    $page->keywords = explode(',',str_replace(' ','',$page->keywords));
  
	    $this->cache->set('cms_page_get_page_'.$id,$page);
	}
	return $page;
    }
}