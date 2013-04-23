<?php defined('SYSPATH') OR die('No direct access allowed.');

class Admin_Controller extends Controller 
{

    public function __construct()
    {
        parent::__construct();

	if ( $this->uri->segment(2)!="login" && $this->session->get('admin',0)==0 )
	url::redirect(url::base().'admin/login');;

    }
    private function __prepare($file)
    {
	$this->template->title = 'Panel administracyjny';
	
	$this->template->body->view = new View('admin/'.$file);
	$this->template->panel = new View('admin/menu');
	$this->template->panel->menu = array('Panel administracyjny'=>array("Witaj"=>"welcome","Wyloguj się"=>"logout"),"CMS"=>array("Strony"=>"cms_pages","Pliki"=>"cms_files"),"Blog"=>array("Blogroll"=>"blog_blogroll","Kategorie"=>"blog_categories","Wpisy"=>"blog_notes"));
    }

    public function index()
    {
	if ( $this->session->get('admin',0)==0 )
	url::redirect(url::base().'admin/login');
	else
	url::redirect(url::base().'admin/welcome');
   }

    public function login()
    {
	$this->template->page	= 7;
	$this->template->title  = "Panel administracyjny";
	$this->template->body->view = new View('admin/login');
	
	$this->template->background = "data/upload/2009-06-01/body.jpg";
	
	if ("admin"==$this->input->post('login') && "admin"==$this->input->post('password'))
	{
	    $this->session->set('admin' , 1);
	    url::redirect(url::base().'admin/welcome');
	}
    }

    public function logout()
    {
	$this->session->delete('admin');
	url::redirect(url::base().'welcome');
    }

    public function welcome()
    {
	$this->__prepare('welcome');
    }

    public function cms_pages($mode="index",$data=0)
    {
	$this->__prepare('cms_pages');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "index":
		$pages = Database::instance()->query('SELECT p.* FROM cms_pages p ORDER BY `order` ASC');
		$this->template->body->view->pages = $pages;
		break;   
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE cms_pages SET date=now(),keywords="'.$this->input->post("keywords").'",title="'.$this->input->post("title").'",name="'.$this->input->post("name").'",text="'.addslashes($this->input->post("text")).'",description="'.addslashes($this->input->post("description")).'",url='.(int)(($this->input->post("url")=="url")?(1):(0)).',visible='.(int)(($this->input->post("visible")=="visible")?(1):(0)).',background="'.$this->input->post("background").'",category_id='.(int)$this->input->post("category_id",1).' WHERE id='.$data);
		    url::redirect(url::base().'admin/cms_pages/edit/'.$data);
		}
		$pages = Database::instance()->query('SELECT p.* FROM cms_pages p WHERE id='.$data);
		$this->template->body->view->page = $pages[0];

		$categories = Database::instance()->query('SELECT * FROM cms_categories ORDER BY `order` ASC');
		$this->template->body->view->categories = $categories;
		break;
	    case "add":
		$result = $this->db->query('SELECT MAX(`order`) as max FROM cms_pages');
		$this->db->query('INSERT INTO cms_pages(category_id,`order`,visible,date) VALUES(1,'.($result[0]->max+1).',0,now())');
		url::redirect(url::base().'admin/cms_pages/index');
		break;
	    case "remove":
		$result = $this->db->query('SELECT `order` FROM cms_pages WHERE id='.$data);
		$order = $result[0]->order;
		$this->db->query('UPDATE cms_pages SET `order`=`order`-1 WHERE `order`>='.($order));
		$this->db->query('DELETE FROM cms_pages WHERE id='.$data);

		url::redirect(url::base().'admin/cms_pages/index');
		break;
	    case "up":
		$result = $this->db->query('SELECT `order` FROM cms_pages WHERE id='.$data);
		$order = $result[0]->order;
		if ($order>1)
		{
		    $this->db->query('UPDATE cms_pages SET `order`='.($order).' WHERE `order`='.($order-1));
		    $this->db->query('UPDATE cms_pages SET `order`='.($order-1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/cms_pages/index');
		break;
	    case "down":
		$result = $this->db->query('SELECT `order` FROM cms_pages WHERE id='.$data);
		$order = $result[0]->order;
		$result = $this->db->query('SELECT MAX(`order`) as mmax FROM cms_pages');
		$max = $result[0]->mmax;
		if ($order<$max)
		{
		    $this->db->query('UPDATE cms_pages SET `order`='.($order).' WHERE `order`='.($order+1));
		    $this->db->query('UPDATE cms_pages SET `order`='.($order+1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/cms_pages/index');
		break;
	}
    }

    public function blog_blogroll($mode="index",$data=0)
    {
	$this->__prepare('blog_blogroll');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "index":
		$links = Database::instance()->query('SELECT l.* FROM blog_blogroll l ORDER BY `order` ASC');
		$this->template->body->view->links = $links;
		break;   
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_blogroll SET title="'.$this->input->post("title").'",url="'.$this->input->post("url").'",visible='.(int)(($this->input->post("visible")=="visible")?(1):(0)).' WHERE id='.$data);
		    url::redirect(url::base().'admin/blog_blogroll/edit/'.$data);
		}
		$links = Database::instance()->query('SELECT l.* FROM blog_blogroll l WHERE id='.$data);
		$this->template->body->view->link = $links[0];
		break;
	    case "add":
		$result = $this->db->query('SELECT MAX(`order`) as max FROM blog_blogroll');
		$this->db->query('INSERT INTO blog_blogroll(title,url,`order`,visible) VALUES("brak","brak",'.($result[0]->max+1).',0)');
		url::redirect(url::base().'admin/blog_blogroll/index');
		break;
	    case "remove":
		$result = $this->db->query('SELECT `order` FROM blog_blogroll WHERE id='.$data);
		$order = $result[0]->order;
		$this->db->query('UPDATE blog_blogroll SET `order`=`order`-1 WHERE `order`>='.($order));
		$this->db->query('DELETE FROM blog_blogroll WHERE id='.$data);
		url::redirect(url::base().'admin/blog_blogroll/index');
		break;
	    case "up":
		$result = $this->db->query('SELECT `order` FROM blog_blogroll WHERE id='.$data);
		$order = $result[0]->order;
		if ($order>1)
		{
		    $this->db->query('UPDATE blog_blogroll SET `order`='.($order).' WHERE `order`='.($order-1));
		    $this->db->query('UPDATE blog_blogroll SET `order`='.($order-1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/blog_blogroll/index');
		break;
	    case "down":
		$result = $this->db->query('SELECT `order` FROM blog_blogroll WHERE id='.$data);
		$order = $result[0]->order;
		$result = $this->db->query('SELECT MAX(`order`) as mmax FROM blog_blogroll');
		$max = $result[0]->mmax;
		if ($order<$max)
		{
		    $this->db->query('UPDATE blog_blogroll SET `order`='.($order).' WHERE `order`='.($order+1));
		    $this->db->query('UPDATE blog_blogroll SET `order`='.($order+1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/blog_blogroll/index');
		break;
	}
    }

    public function blog_categories($mode="index",$data=0)
    {
	$this->__prepare('blog_categories');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "index":
		$categories = Database::instance()->query('SELECT c.* FROM blog_categories c ORDER BY `order` ASC');
		$this->template->body->view->categories = $categories;
		break;   
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_categories SET title="'.$this->input->post("title").'",name="'.$this->input->post("name").'",visible='.(int)(($this->input->post("visible")=="visible")?(1):(0)).' WHERE id='.$data);
		    url::redirect(url::base().'admin/blog_categories/edit/'.$data);
		}
		$categories = Database::instance()->query('SELECT c.* FROM blog_categories c WHERE id='.$data);
		$this->template->body->view->category = $categories[0];
		break;
	    case "add":
		$result = $this->db->query('SELECT MAX(`order`) as max FROM blog_categories');
		$this->db->query('INSERT INTO blog_categories(`order`,visible) VALUES('.($result[0]->max+1).',0)');
		url::redirect(url::base().'admin/blog_categories/index');
		break;
	    case "remove":
		$result = $this->db->query('SELECT `order` FROM blog_categories WHERE id='.$data);
		$order = $result[0]->order;
		$this->db->query('UPDATE blog_categories SET `order`=`order`-1 WHERE `order`>='.($order));
		$this->db->query('DELETE FROM blog_categories WHERE id='.$data);
		$this->db->query('DELETE FROM blog_notes_categories WHERE category_id='.$data);   
		url::redirect(url::base().'admin/blog_categories/index');
		break;
	    case "up":
		$result = $this->db->query('SELECT `order` FROM blog_categories WHERE id='.$data);
		$order = $result[0]->order;
		if ($order>1)
		{
		    $this->db->query('UPDATE blog_categories SET `order`='.($order).' WHERE `order`='.($order-1));
		    $this->db->query('UPDATE blog_categories SET `order`='.($order-1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/blog_categories/index');
		break;
	    case "down":
		$result = $this->db->query('SELECT `order` FROM blog_categories WHERE id='.$data);
		$order = $result[0]->order;
		$result = $this->db->query('SELECT MAX(`order`) as mmax FROM blog_categories');
		$max = $result[0]->mmax;
		if ($order<$max)
		{
		    $this->db->query('UPDATE blog_categories SET `order`='.($order).' WHERE `order`='.($order+1));
		    $this->db->query('UPDATE blog_categories SET `order`='.($order+1).' WHERE `id`='.($data));
		}
		url::redirect(url::base().'admin/blog_categories/index');
		break;
	}
    }

    public function blog_notes($mode="index",$data=0,$data2=0,$data3=0)
    {
	$this->__prepare('blog_notes');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "index":
		$notes = Database::instance()->query('SELECT n.* FROM blog_notes n ORDER BY `date` DESC');
		$this->template->body->view->notes = $notes;
		break;   
	    case "remove_tag":
		$this->db->query('DELETE FROM blog_notes_tags WHERE note_id=? AND tag_id=?',$data,$data2);
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "insert_tag":
		$this->db->query('INSERT INTO blog_notes_tags(note_id,tag_id) VALUES('.$data.','.$data2.')');
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "remove_category":
		$this->db->query('DELETE FROM blog_notes_categories WHERE note_id=? AND category_id=?',$data,$data2);
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "insert_category":
		$this->db->query('INSERT INTO blog_notes_categories(note_id,category_id) VALUES('.$data.','.$data2.')');
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_notes SET title="'.$this->input->post("title").'",name="'.$this->input->post("name").'",date="'.$this->input->post("date").'",text="'.addslashes($this->input->post("text")).'",description="'.addslashes($this->input->post("description")).'",visible='.(int)(($this->input->post("visible")=="visible")?(1):(0)).',rating='.(int)$this->input->post("rating",1).',rating_count='.(int)$this->input->post("rating_count",1).' WHERE id='.$data);
		    url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		}
		$notes = Database::instance()->query('SELECT n.* FROM blog_notes n WHERE id='.$data);
		$this->template->body->view->note = $notes[0];
		
		$categories = Database::instance()->query('SELECT c.* FROM blog_categories c ORDER BY `order` ASC');
		$this->template->body->view->categories = $categories;

		$comments = Database::instance()->query('SELECT c.* FROM blog_comments c WHERE note_id='.$data.' ORDER BY `date` DESC');
		$this->template->body->view->comments = $comments;

		$photos = Database::instance()->query('SELECT p.* FROM blog_photos p WHERE note_id='.$data);
		$this->template->body->view->photos = $photos;

		$files = Database::instance()->query('SELECT f.* FROM blog_files f WHERE note_id='.$data);
		$this->template->body->view->files = $files;

		$tags = Database::instance()->query('SELECT blog_tags.* FROM blog_tags, blog_notes_tags WHERE blog_tags.id = blog_notes_tags.tag_id AND blog_notes_tags.note_id='.$data);
		$this->template->body->view->tags1 = $tags;
		$tags = Database::instance()->query('SELECT blog_tags.* FROM blog_tags LEFT JOIN blog_notes_tags ON blog_tags.id = blog_notes_tags.tag_id AND blog_notes_tags.note_id='.$data.' WHERE blog_notes_tags.note_id IS NULL;');
		$this->template->body->view->tags2 = $tags;

		$categories = Database::instance()->query('SELECT blog_categories.* FROM blog_categories, blog_notes_categories WHERE blog_categories.id = blog_notes_categories.category_id AND blog_notes_categories.note_id='.$data);
		$this->template->body->view->categories1 = $categories;
		$categories = Database::instance()->query('SELECT blog_categories.* FROM blog_categories LEFT JOIN blog_notes_categories ON blog_categories.id = blog_notes_categories.category_id AND blog_notes_categories.note_id='.$data.' WHERE blog_notes_categories.note_id IS NULL;');
		$this->template->body->view->categories2 = $categories;


		break;
	    case "add":
		$this->db->query('INSERT INTO blog_notes(date,visible) VALUES(now(),0)');
		url::redirect(url::base().'admin/blog_notes/index');
		break;
	    case "remove":
		$this->db->query('DELETE FROM blog_notes WHERE id='.$data);
		$this->db->query('DELETE FROM blog_notes_categories WHERE note_id='.$data);
		$this->db->query('DELETE FROM blog_comments WHERE note_id='.$data);
		$this->db->query('DELETE FROM blog_photos WHERE note_id='.$data);
		$this->db->query('DELETE FROM blog_files WHERE note_id='.$data);
		url::redirect(url::base().'admin/blog_notes/index');
		break;
	}
    }

    public function blog_comments($mode="index",$data=0)
    {
	$this->__prepare('blog_comments');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_comments SET active='.(int)(($this->input->post("active")=="active")?(1):(0)).',user="'.$this->input->post("user").'",system='.$this->input->post("system").',date="'.$this->input->post("date").'",text="'.addslashes($this->input->post("text")).'" WHERE id='.$data);
		    url::redirect(url::base().'admin/blog_comments/edit/'.$data);
		}
		$comments = Database::instance()->query('SELECT c.* FROM blog_comments c WHERE id='.$data);
		$this->template->body->view->comment = $comments[0];
		break;
	    case "add":
		$this->db->query('INSERT INTO blog_comments(text,user,note_id,date,system) VALUES("","",'.$data.',now(),1)');
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "remove":
		$result = $this->db->query('SELECT note_id FROM blog_comments WHERE id='.$data);
		$this->db->query('DELETE FROM blog_comments WHERE id='.$data);
		url::redirect(url::base().'admin/blog_notes/edit/'.$result[0]->note_id);
		break;
	}
    }

    public function blog_photos($mode="index",$data=0)
    {
	$this->__prepare('blog_photos');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_photos SET title="'.$this->input->post("title").'",`url`="'.$this->input->post("url").'" WHERE id='.$data);  
		    url::redirect(url::base().'admin/blog_photos/edit/'.$data);
		}
		$photos = Database::instance()->query('SELECT * FROM blog_photos WHERE id='.$data);
		$this->template->body->view->photo = $photos[0];
		break;
	    case "add":
		$this->db->query('INSERT INTO blog_photos(note_id) VALUES('.$data.')');
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "remove":
		$result = $this->db->query('SELECT note_id FROM blog_photos WHERE id='.$data);
		$this->db->query('DELETE FROM blog_photos WHERE id='.$data);
		url::redirect(url::base().'admin/blog_notes/edit/'.$result[0]->note_id);
		break;
	}
    }

    public function blog_files($mode="index",$data=0)
    {
	$this->__prepare('blog_files');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "edit":
		if ($this->input->post("id"))
		{
		    $this->db->query('UPDATE blog_files SET title="'.$this->input->post("title").'", url="'.$this->input->post("url").'" WHERE id='.$data);
		    url::redirect(url::base().'admin/blog_files/edit/'.$data);
		}
		$files = Database::instance()->query('SELECT f.* FROM blog_files f WHERE id='.$data);
		$this->template->body->view->file = $files[0];
		break;
	    case "add":
		$this->db->query('INSERT INTO blog_files(note_id) VALUES('.$data.')');
		url::redirect(url::base().'admin/blog_notes/edit/'.$data);
		break;
	    case "remove":
		$result = $this->db->query('SELECT note_id FROM blog_files WHERE id='.$data);
		$this->db->query('DELETE FROM blog_files WHERE id='.$data);
		url::redirect(url::base().'admin/blog_notes/edit/'.$result[0]->note_id);
		break;
	}
    }

    public function cms_files($mode="index",$data=0)
    {
	$this->__prepare('cms_files');
	$this->template->body->view->mode=$mode;

	switch ($mode)
	{
	    case "index":
		$files = Database::instance()->query('SELECT id,name, DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM cms_files ORDER BY `date` DESC');
		$this->template->body->view->files = $files;
		break;
	    case "edit":
		if ($this->input->post("id"))
		{
		}
		break;
	    case "add":
		if (isset($_FILES['file']['tmp_name']))
		{
		    $upload = new Upload_Model();
		    $upload->upload();
		    url::redirect(url::base().'admin/cms_files');
		}
		break;
	    case "remove":
		$upload = new Upload_Model();
		$upload->remove($data);
		url::redirect(url::base().'admin/cms_files');
		break;
	}
    }

}