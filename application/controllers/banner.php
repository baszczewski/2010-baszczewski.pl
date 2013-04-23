<?php defined('SYSPATH') or die('No direct script access.');

class Banner_Controller extends Controller
{
    public $template=false;

    private $frames,$framed,$fps;
    private $text,$background;

    public function __construct()
    {
	parent::__construct();

	$this->frames = array();
	$this->framed = array();
	$this->fps = 15;
	$this->cache = new Cache(array('lifetime' => 60*60*12));//60*60*12
    }

    private function _text()
    {
	for ($i = 1; $i<=$this->fps; $i++)
	{
	    ob_start();
	    $image=ImageCreateFromGIF($this->background);
	    $color = imagecolorallocate($image, 255, 255, 255);
	    ImageTTFText($image, 12, 0, 27+10*sin((($i)/$this->fps)*pi()), 19, $color, 'data/banner/DejaVuSans.ttf', $this->text);
	    imagegif($image); 
	    imagedestroy($image);
	    $this->frames[] = ob_get_clean();
	    $this->framed[] = ($i==$this->fps) ?400:5;
	}
    }

    public function index()
    {
	$banner = $this->cache->get('banner');
	if (!$banner)
	{
	    $this->background = 'data/banner/bg1.gif';
	    $this->text = 'Skrypt';
	    $this->_text();

	    $this->background = 'data/banner/bg2.gif';
	    $notes = Database::instance()->query('SELECT title FROM blog_notes ORDER BY RAND() LIMIT 1');
	    foreach ($notes as $note)
	    {
		$this->text = $note->title;
		$this->_text();
	    }

	    $gif = new GIFEncoder($this->frames,$this->framed,0,2,0, 0, 0,0,"bin");
	    
	    $banner = $gif->GetAnimation ( );
	    $this->cache->set('banner',$banner);
	}
	Header ( 'Content-type:image/gif' );
	    echo $banner;
    }
}