<?php defined('SYSPATH') or die('No direct script access.');

class Ajax_Controller extends Controller
{
    public $template=false;

    public function __construct()
    {
	parent::__construct();
	if (isset($_POST['data']))
	    if ($_POST['data']!='null') 
		$this->data = json_decode($_POST['data']);
    }
    public function rating()
    {
	$result = array();
	$result['success']=true;

	if (!Session::instance()->get('rating_'.$this->data->id,false))
	{
	    $rating = $this->db->query('SELECT n.rating, n.rating_count FROM blog_notes n WHERE n.id='.$this->data->id);

	    $newrating = $rating[0]->rating+$this->data->rating;
	    $newcount = $rating[0]->rating_count+1;

	    $this->db->query('UPDATE blog_notes SET rating='.$newrating.',rating_count='.$newcount.' WHERE id='.$this->data->id);
	      
	    $result['rating'] = round($newrating/$newcount,0);

	    Session::instance()->set('rating_'.$this->data->id,true);
	}	
	echo json_encode($result);
    }
}