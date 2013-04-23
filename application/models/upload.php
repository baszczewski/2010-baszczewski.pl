<?php defined('SYSPATH') or die('No direct script access.');

class Upload_Model extends Model
{
    private $table;
    public function __construct($table="cms_files")
    {
	parent::__construct();
	$this->table = $table;
    }

    public function upload($index="file")
    {
	if (!isset($_FILES[$index]['tmp_name']))
	    return;

	$file = $_FILES[$index]['tmp_name'];

	$date = date("Y-m-d");
	$dir = 'data/upload/'.$date.'/';
	if (!file_exists($dir))
	    mkdir($dir);

	if(is_uploaded_file($file)) 
	{
	    $name = $_FILES[$index]['name'];

	    if (file_exists($dir.$name))
		unlink($dir.$name);
	    else
	    Database::instance()->query('INSERT INTO '.$this->table.'(name,date,type) VALUES("'.$name.'",now(),'.((int)$_POST['type']).')');

	    move_uploaded_file($file, $dir.$name);

	    if ($_POST['type']==1)
	    {
		ini_set("memory_limit","20M");
		$image = ImageCreateFromJPEG($dir.$name);
		list($width, $height) = getimagesize($dir.$name);
		$scale=1;
		if ($width>505) 
		    $scale=$width/505;
		$newWidth = round($width/$scale);
		$newHeight = round($height/$scale);
		$image1 = imagecreatetruecolor($newWidth,$newHeight);
		imagecopyresampled ( $image1 , $image, 0,0,0,0, $newWidth, $newHeight, $width,$height);
		ImageJPEG($image1,$dir.$name,90);
		imagedestroy($image);
		imagedestroy($image1);
	    }
	    if ($_POST['type']==2)
	    {
		ini_set("memory_limit","20M");
		$image = ImageCreateFromJPEG($dir.$name);
		list($width, $height) = getimagesize($dir.$name);

		$scale=1;
		if ($width>700) $scale=$width/700;
		$newWidth = round($width/$scale);
		$newHeight = round($height/$scale);
		$image1 = imagecreatetruecolor($newWidth,$newHeight);
		$image2 = imagecreatetruecolor (120,120);
		
		imagecopyresampled ( $image1 , $image, 0,0,0,0, $newWidth, $newHeight, $width,$height);
		if ($newWidth>$newHeight)
		imagecopyresampled ( $image2 , $image1, 0,0,($newWidth-$newHeight)/2,0, 120, 120, $newHeight,$newHeight);
		else
		imagecopyresampled ( $image2 , $image1, 0,0,0,($newHeight-$newWidth)/2, 120, 120, $newWidth,$newWidth);
		
		ImageJPEG($image1,$dir.$name,90);
		ImageJPEG($image2,$dir.$name.'.thumb.jpg',90);
		imagedestroy($image);
		imagedestroy($image1);
		imagedestroy($image2);
	    }
	}
    }

    public function remove($id)
    {
	$files = Database::instance()->query('SELECT name, DATE_FORMAT(`date`, "%Y-%m-%d") as date FROM '.$this->table.' WHERE id='.$id);
	$file = $files[0]->name;
	$date = $files[0]->date;
	$this->db->query('DELETE FROM '.$this->table.' WHERE id='.$id);

	$dir = 'data/upload/'.$date;
	if (!file_exists($dir))
	    return;

	$count = 0;
	$folder = opendir($dir);
	while($a = readdir($folder))
	{
	    if($a!='.' && $a!='..')
		$count++;
	}
	closedir($folder);

	if (file_exists($dir.'/'.$file))
	{
	    unlink($dir.'/'.$file);
	    $count--;
	}

	if (file_exists($dir.'/'.$file.'.thumb.jpg'))
	{
	    unlink($dir.'/'.$file.'.thumb.jpg');
	    $count--;
	}

	if ( ($count==0) && (file_exists($dir)) )
	    rmdir($dir);
    }
} 
