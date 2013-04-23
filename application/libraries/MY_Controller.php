<?php
class Controller extends Controller_Core
{
    public $db,$template=true,$session,$input;
    
    public function __construct()
    {
        parent::__construct();

        $this->db = Database::instance();
        $this->session = Session::instance();
        $this->input = Input::instance();

        if ($this->template==true)
      	{
      		Event::add('system.post_controller_constructor', array($this, '_prepare'));
      		Event::add('system.post_controller', array($this, '_render'));
      	}
    }

    private function _name()
    {
	$class  = new ReflectionClass($this);
	$temp = strtolower(array_shift(explode('_',$class->getName())));
	return $temp;
    }

    public function _prepare()
    {
	$this->template = new View('template');
	if (!isset($this->template->body))
	$this->template->body = new View($this->_name());

	$this->template->keywords = array('testowy', 'skrypt');

	$pages = new Cms_page_Model;
	$list = $pages->get_list(2);
	$this->template->menu = $list;
    }
    public function _render()
    {
    	$this->template->render(TRUE);
    }
}