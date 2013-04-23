<?php defined('SYSPATH') OR die('No direct access allowed.');

class Errors_Controller extends Controller 
{
    public function __construct()
    {
        parent::__construct();
	$this->template 		= new View('template');
	if (!isset($this->template->body))
	$this->template->body = new View('errors');

	$pages = new Cms_page_Model;
	$this->template->menu = $pages->get_list(2);

	$pages = new Cms_page_Model;
	$page = $pages->get_page(1);
	$this->template->background = $page->background;
    }
    public function index()
    {
    }
    public function error_404()
    {
    }
    public function _render()
    {

    	$this->template->render(TRUE);
    }
}