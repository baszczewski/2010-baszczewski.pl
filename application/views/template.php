<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl-PL"> 
    <head>
	<title>Skrypt<?= (isset($title))?(" - ".$title):("") ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<base href="<?= url::base() ?>" />
	<meta name="author" content="Marcin Baszczewski" />
	<meta name="copyright" content="Copyright (c) 2009 Marcin Baszczewski" />
	<meta name="description" content="<?= isset($description)?(text::limit_chars($description, 256, '...')):('Skrypt'); ?>" />
	<meta name="keywords" content="<?= isset($keywords)?(text::limit_words(implode(', ',$keywords), 30, '')):(""); ?>" /> 
	
	<?= ($this->uri->segment(1)=="blog")?('<link rel="alternate" type="application/rss+xml" title="Baszczewski.pl" href="http://baszczewski.pl/blog/czytnik" />'):("") ?>
	<link rel="stylesheet" type="text/css" media="all" href="data/css/default.css" />
	
	<script type="text/javascript" src="data/js/mootools-core.js"></script>
	<script type="text/javascript" src="data/js/mootools-more.js"></script>
	<script type="text/javascript" src="data/js/homepage.js"></script>
	<script type="text/javascript" src="data/js/slimbox.js"></script>
	<script type="text/javascript">
	    window.addEvent('domready', function() 
	    {
		    app = new homepage();
	    });
	</script>
    </head>
    <body>
	<div id="top">
	    <div id="logo"></div>
	    <a class="baszczewski" href="<?= url::base() ?>">Skrypt</a>
	    <div id="menu">
		<? foreach ($menu as $key=>$item): ?>
		    <div class="item"><div></div><a href="<?= ($item->url)?($item->name):("strona/".($item->name)) ?>"><?= $item->title ?></a></div>
		<? endforeach; ?>
	    </div>
	</div>

	<div id="frame_top"></div>

	<div id="frame">
	    <div id="body">
		<div id="background" <?= ((isset($background))?('style="background-image: url('.$background.');"'):("")) ?>><div style="width:251px;float:left;"><?= (isset($panel)?$panel:'') ?></div><div <?= ((isset($panel))?'':'style="height:426px;"') ?> class="text"><?= $body ?></div></div>
	    </div>
	</div>

	<div id="frame_bottom"></div>

	<div id="footer"><div class="left">© <?= date("Y") ?> <a href="<?= url::base() ?>">Stopka</a></div><div class="right"><a rel="external nofollow" href="http://creativecommons.org/licenses/by/3.0/deed.pl">Creative Commons</a></div></div>
    </body>
</html>