<?php defined('SYSPATH') or die('No direct script access.');
 
class Blog_category_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }
    
    public function get()
    {
	$categories = $this->cache->get('blog_category_get');
	if (!$categories)
	{
	    $result = Database::instance()->query('SELECT 
		c.name,
		c.title,
		c.visible,
		count(n.id) as count FROM blog_categories c, blog_notes s, blog_notes_categories n WHERE n.category_id=c.id AND s.visible=1 AND s.id=n.note_id AND c.visible=1 GROUP BY c.id ORDER BY c.order ASC');	
	    if (count($result)==0)
		return 0;

	    $categories = array();    
	    foreach ($result as $item)
		$categories[] = $item;

	    $this->cache->set('blog_category_get',$categories);
	}
	return $categories;
    }
}