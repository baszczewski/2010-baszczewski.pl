<?php defined('SYSPATH') or die('No direct script access.');

class Sitemap_Controller extends Controller
{
    public $template=false;

    public function __construct()
    {
	parent::__construct();
    }

    public function index()
    {
	$sitemap=new Sitemap; //create new sitemap

	//pages
	$pages = Database::instance()->query('SELECT id,url,name as name,DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM cms_pages WHERE name="welcome"');
	$sitemap->add_url(url::base(),$pages[0]->date ,'monthly',"1");

	$pages = Database::instance()->query('SELECT id,url,name as name,DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM cms_pages WHERE name="kontakt"');
	$sitemap->add_url(url::base().'kontakt/',$pages[0]->date ,'yearly',"0.2");//0.2

	$pages = Database::instance()->query('SELECT id,url,name as name,DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM cms_pages WHERE url="" AND visible=1');
	foreach ($pages as $page)
	    $sitemap->add_url(url::base().'strona/'.(($page->name!="")?$page->name:$page->id),$page->date ,'monthly',"0.9");//0.9

	//blog
	$notes = Database::instance()->query('SELECT id,name,DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM blog_notes WHERE text!="" AND visible=1 ORDER BY `date` DESC');
	$sitemap->add_url(url::base().'blog/',$notes[0]->date ,'hourly',"1");
	
	foreach ($notes as $key=>$note)
	    $sitemap->add_url(url::base().'blog/czytaj/'.(($note->name!="")?$note->name:$note->id),$note->date ,'hourly',"0.8");//0.8

	$sitemap->location=url::base().'sitemap.xml'; //not necessary really since this url is assumed
	echo $sitemap->render(); //will output the sitemap and add an xml header
	$sitemap->ping_google();//tell Google about the sitemap
    }
}