<?php defined('SYSPATH') OR die('No direct access allowed.');

class Welcome_Controller extends Controller 
{
    public function index()
    {
	$this->template->body = new View("page");

	$pages = new Cms_page_Model;
	$page = $pages->get_page(1);

	$this->template->body->text = $page->text;
	$this->template->keywords = array_unique(array_merge($this->template->keywords,$page->keywords));
	$this->template->background = $page->background;
    }
}