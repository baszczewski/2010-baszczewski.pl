<?php defined('SYSPATH') or die('No direct script access.');
 
class Blog_comment_Model extends Model
{
    public function __construct()
    {
	parent::__construct();
	$this->cache = new Cache(array('lifetime' => 60*60));
    }
    
    public function get()
    {

	$result = Database::instance()->query('SELECT c.id, c.text, n.name FROM blog_comments c, blog_notes n WHERE  c.active=1 AND c.note_id=n.id AND n.visible=1 ORDER BY c.`date` DESC LIMIT 0,5');
	$comments = array();
	foreach ($result as $item)
	    $comments[]=$item;
	return $comments;
    }
}