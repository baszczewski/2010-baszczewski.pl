<? if (isset($web_pages) || isset($native_apps) || isset($graphics)):?>
    <? if ($web_pages): ?>
	<h2><?= Kohana::lang('projects.web_pages') ?></h2>
	<br/>
	<? foreach($web_pages as $page): ?>
	    <span class="technology"><?= $page->title ?></span>
	    <?= $page->description ?>
	    <a href="blog/<?= strtolower(Kohana::lang('blog.tags')) ?>/<?= $page->name ?>"><?= Kohana::lang('projects.more') ?></a>.
	    <br/>
	<? endforeach; ?>
    <? endif; ?>
    <br/>
    <? if ($native_apps): ?>
	<h2><?= Kohana::lang('projects.native_apps') ?></h2>
	<br/>
	<? foreach($native_apps as $page): ?>
	    <span class="technology"><?= $page->title ?></span>
	    <?= $page->description ?>
	    <a href="blog/<?= strtolower(Kohana::lang('blog.tags')) ?>/<?= $page->name ?>"><?= Kohana::lang('projects.more') ?></a>.
	    <br/>
	<? endforeach; ?>
    <? endif; ?>
    <br/>
    <? if ($graphics): ?>
	<h2><?= Kohana::lang('projects.graphics') ?></h2>
	<br/>
	<? foreach($graphics as $page): ?>
	    <span class="technology"><?= $page->title ?></span>
	    <?= $page->description ?>
	    <a href="blog/<?= strtolower(Kohana::lang('blog.tags')) ?>/<?= $page->name ?>"><?= Kohana::lang('projects.more') ?></a>.
	    <br/>
	<? endforeach; ?>
    <? endif; ?>
<? endif; ?>