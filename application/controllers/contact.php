<?php defined('SYSPATH') OR die('No direct access allowed.');

class Contact_Controller extends Controller 
{
    public function index()
    {
	$pages = new Cms_page_Model;
	
	$page = $pages->get_page("kontakt");
	$this->template->background = $page->background;
	$this->template->title = $page->title;
	$this->template->keywords = array_unique(array_merge($this->template->keywords,$page->keywords));
	if ($page->description!='')
	    $this->template->description = $page->description;

	$name = cookie::get('contact-name');
	$email = cookie::get('contact-email');
	if ($this->input->post())
	{

	    $post = new Validation($_POST);
	    $post->add_rules('*', 'required');
	    $post->add_rules('email', array('valid','email'));
	    $post->add_rules('name','standard_text');
	
	    if($post->validate())
	    {
		$swift = email::connect();
		$from = "test@test.pl";
		$subject = $this->input->post("name")."(".$this->input->post("email").")";
		$message = addslashes($this->input->post("text"));
	
		$recipients = new Swift_RecipientList;
		$recipients->addTo('test@test.pl');

		$message = new Swift_Message($subject, $message, "text/html");
		if ($swift->send($message, $recipients, $from))
		    $this->template->body->send = 1;
		else
		    $this->template->body->send = 0;

		$swift->disconnect();
	    }
	    else
	    {
		$this->template->body->send = -1;
		$this->template->body->text = $this->input->post("text");
	    }
	    $name = $this->input->post("name");
	    $email = $this->input->post("email");
	    cookie::set('contact-name', $name);
	    cookie::set('contact-email', $email);
	}
	$this->template->body->name = $name;
	$this->template->body->email = $email;
    }
}