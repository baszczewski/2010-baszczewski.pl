<?php defined('SYSPATH') OR die('No direct access allowed.');

class Blog_Controller extends Controller 
{
    public function index($category=0,$page=1)
    {
	$category_str = "";
	if ($category!=(string)0)
	{
	    $result = Database::instance()->query('SELECT title FROM blog_categories WHERE name=?',$category,$category);
	    if (count($result)>0)
		$category_str = $result[0]->title;
	}
	if ($category==(string)0 && $page==(string)1)
	    $this->template->title = "Blog";
	elseif($category!=(string)0 && $page==(string)1)
	    $this->template->title = "Kategoria - ".$category_str;
	elseif($category===(string)0)
	    $this->template->title = "Archiwum - ".$page;
	else
	    $this->template->title = "Archiwum - ".$category_str." - ".$page;

	$per_page=6;
	$this->template->body = new View('blog');
	$this->template->body->show_comments = false;

	$notes = new Blog_note_Model;
	$temp = $notes->get_notes($category,$page,$per_page);
	if (!$temp)
	   return Event::run('system.404'); 

	$this->template->body->notes = $temp;
      
	$parta = ((empty($category)==true)?("archiwum"):($category));
	$partb = ((empty($category)==false)?("blog/archiwum"):("blog"));

	$pagination = new Pagination(array('uri_segment'    => $parta,'base_url'    => $partb,'total_items'    => $notes->count_notes($category), 'items_per_page' => $per_page, 'style'=> 'punbb'));
	$this->template->body->pagination = $pagination;


	$this->_panel();
    }

    public function tags($tags=0,$page=1)
    {
	$tags_str = "";
	if ($tags!=(string)0)
	{
	    $result = Database::instance()->query('SELECT title FROM blog_tags WHERE name=?',$tags,$tags);
	    if (count($result)>0)
		$tags_str = $result[0]->title;
	}
	if ($tags==(string)0 && $page==(string)1)
	    $this->template->title = "Blog";
	elseif($tags!=(string)0 && $page==(string)1)
	    $this->template->title = "Tagi - ".$tags_str;
	elseif($tags===(string)0)
	    $this->template->title = "Archiwum - ".$page;
	else
	    $this->template->title = "Archiwum - ".$tags_str." - ".$page;

	$per_page=6;
	$this->template->body = new View('blog');
	$this->template->body->show_comments = false;

	$notes = new Blog_note_Model;
	$temp = $notes->get_notes($tags,$page,$per_page,2);
	if (!$temp)
	   return Event::run('system.404'); 

	$this->template->body->notes = $temp;
      
	$parta = ((empty($tags)==true)?("archiwum"):($tags));
	$partb = ((empty($tags)==false)?("blog/tagi"):("blog"));

	$pagination = new Pagination(array('uri_segment'    => $parta,'base_url'    => $partb,'total_items'    => $notes->count_notes($tags,2), 'items_per_page' => $per_page, 'style'=> 'punbb'));
	$this->template->body->pagination = $pagination;

	$this->_panel();
    }

    public function show($index)
    {
	$this->template->body->show_comments = true;
	$this->template->body->send = 0;
	$name = cookie::get('blog-name');
	$email = cookie::get('blog-email');
	$website = cookie::get('blog-website');
	$last = 0;
	if ($this->input->post())
	{
	    $post = new Validation($_POST);
	    $post->add_rules('name','required','standard_text');
	    $post->add_rules('email','required','email');
	    $post->add_rules('text','required');
	    $post->add_rules('website','url');
	    if($post->validate())
	    {
		$brow = strtolower($_SERVER['HTTP_USER_AGENT']);
	
		$system = 0;
		if(strpos($brow, 'windows') !== false) 
		    $system = 2;
		elseif(strpos($brow, 'linux') !== false) 
		    $system = 1;
		elseif(strpos($brow, 'mac os') !== false) 
		    $system = 3;
		else 
		    $system = 0;


		$this->template->body->send = 1;
		$query = $this->db->query('INSERT INTO blog_comments(user,text,date,note_id,system,website,active) VALUES("'.$this->input->post("name").'","'.addslashes($this->input->post("text")).'",now(),'.$index.','.$system.',"'.$this->input->post("website").'",0)');
		cookie::set('blog-comment-'.$query->insert_id(), true);
		$last = $query->insert_id();
	    }
	    else
	    {
		$this->template->body->send = -1;
		$this->template->body->text = $this->input->post("text");
	    }
	    $name = $this->input->post("name");
	    $email = $this->input->post("email");
	    $website = $this->input->post("website");
	    cookie::set('blog-name', $name);
	    cookie::set('blog-email', $email);
	    cookie::set('blog-website', $website);
	}
	//$this->template->body->send = 1;
	$this->template->body->name = $name;
	$this->template->body->email = $email;
	$this->template->body->website = $website;

	$notes = new Blog_note_Model;
	$temp = $notes->get_note($index);

	if (!$temp)
	    return Event::run('system.404'); 

	$keywords = array();
	foreach ($temp->tags as $tag)
	    $keywords[]=$tag->title;
	$this->template->keywords = array_unique(array_merge($this->template->keywords,$keywords));

	$this->template->body->notes = array($temp);
	$this->template->body->last = $last;
	$this->template->title = $temp->title;
	$this->template->description = $temp->description;

	$this->_panel();
    }

    private function _panel()
    {
	$notes = new Blog_note_Model;
	$categories = new Blog_category_Model;
	$blogroll = new Blog_blogroll_Model;
	$comments = new Blog_comment_Model;
	$cloud = new Blog_cloud_Model;
	$this->template->panel = new View('blog_menu');
	$this->template->panel->categories = $categories->get();
	$this->template->panel->notes = $notes->get_list();
	$this->template->panel->blogroll = $blogroll->get();
	$this->template->panel->comments = $comments->get();
	$this->template->panel->cloud = $cloud->get();
    }
} 
