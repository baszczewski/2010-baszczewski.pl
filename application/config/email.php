<?php defined('SYSPATH') or die('No direct script access.');

$config['driver'] = 'smtp';
$config['options'] =  array('hostname'=>'smtp.test.pl', 'port'=>'465', 'username'=>'test@test.pl', 'password'=>'test', 'encryption' => 'tls');