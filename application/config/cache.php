<?php defined('SYSPATH') or die('No direct script access.');
$config['driver'] = 'file';
$config['params'] = APPPATH . 'cache';
$config['lifetime'] = 1800;
$config['requests'] = 1000;