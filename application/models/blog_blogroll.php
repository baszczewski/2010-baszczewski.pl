<?php defined('SYSPATH') or die('No direct script access.');
 
class Blog_blogroll_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }
    
    public function get()
    {
	$blogroll = $this->cache->get('blog_blogroll');
	if (!$blogroll)
	{
	    $result = Database::instance()->query('SELECT title, url FROM blog_blogroll WHERE visible=1 ORDER BY `order` ASC');
	    $blogroll = array();
	    foreach ($result as $item)
		$blogroll[]=$item;
	    $this->cache->set('blog_blogroll', $blogroll);
	}
	return $blogroll;
    }
}