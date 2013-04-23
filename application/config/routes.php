<?php defined('SYSPATH') or die('No direct access allowed.');

$config['sitemap.xml'] = 'sitemap';
$config['baner.gif'] = 'banner';
$config['kontakt'] = 'contact';

$config['strona/(.*)'] = 'page/index/$1';
$config['blog/czytnik'] = 'feed';
$config['blog/czytnik/(.*)'] = 'feed/index/$1';

$config['blog/czytaj/(.*)'] = 'blog/show/$1';
$config['blog/strona/(.*)/(.*)'] = 'blog/index/$1/$2';

$config['blog/kategoria/(.*)/(.*)'] = 'blog/index/$1/$2';
$config['blog/kategoria/(.*)'] = 'blog/index/$1';
$config['blog/tagi/(.*)/(.*)'] = 'blog/tags/$1/$2';
$config['blog/tagi/(.*)'] = 'blog/tags/$1';

$config['blog/archiwum/(.*)/(.*)'] = 'blog/index/$1/$2';
$config['blog/archiwum/(.*)'] = 'blog/index/0/$1';