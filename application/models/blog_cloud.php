<?php defined('SYSPATH') or die('No direct script access.');
 
class Blog_cloud_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }
    
    public function get()
    {
	$temp = $this->cache->get('blog_cloud_get');
	if (!$temp)
	{
	    $cloud = new WordCloud();

	    $result = Database::instance()->query('SELECT title, name FROM blog_notes_tags nt, blog_tags t WHERE nt.tag_id=t.id');

	    foreach ($result as $item)
		$cloud->addWord(array('word' => $item->title, 'url' => $item->name)); 

	    $temp = $cloud->showCloud('array');

	    ob_start();
	    foreach ($temp as $cloudArray) 
	    {
		echo ' &nbsp; <a href="blog/tagi/'.$cloudArray['url'].'" class="size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
	    }
	    $temp = ob_get_clean();
	    $this->cache->set('blog_cloud_get',$temp);
	}
	return $temp;
    }
}