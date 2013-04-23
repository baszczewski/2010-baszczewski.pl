<?php defined('SYSPATH') OR die('No direct access allowed.');

class Page_Controller extends Controller 
{
    public function index($name)
    {
	$pages = new Cms_page_Model;
	$page = $pages->get_page($name);

	if (!$page)
	    return Event::run('system.404'); 
	
	$this->template->keywords = array_unique(array_merge($this->template->keywords,$page->keywords));
	$this->template->background = $page->background;
	$this->template->title = $page->title;
	$this->template->body->text = $page->text;
	if ($page->description!='')
	    $this->template->description = $page->description;
    }
}