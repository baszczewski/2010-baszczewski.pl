<div class="category">Kategorie</div>
<? if(count($categories)>0): ?>
    <div class="block">
	<? foreach ($categories as $category): ?>
		<a href="blog/kategoria/<?= $category->name ?>"><?= $category->title ?></a><br/>
	<? endforeach; ?>
    </div>
<? endif; ?>

<div class="category">Tagi</div>
<div id="tags" class="block">
    <?= $cloud ?>
</div>

<? if(count($notes)>0): ?>
    <div class="category">Wpisy</div>
	<div class="block">
	<? foreach ($notes as $note): ?>
	    <a href="blog/czytaj/<?= $note->name ?>"><?= $note->title ?></a><br/>
	<? endforeach; ?>
    </div>
<? endif; ?>

<? if(count($comments)>0): ?>
    <div class="category">Komentarze</div>
    <div class="block">
	<? foreach ($comments as $comment): ?>
	    <a href="blog/czytaj/<?= $comment->name ?>#comment-<?= $comment->id ?>"><?= text::limit_chars($comment->text,30,'...') ?></a><br/>
	<? endforeach; ?>
    </div>
<? endif; ?>

<? if(count($blogroll)>0): ?>
    <div class="category">Blogroll</div>
    <div class="block">
	<? foreach ($blogroll as $link): ?>
	    <a href="<?= $link->url ?>"><?= $link->title ?></a><br/>
	<? endforeach; ?>
    </div>
<? endif; ?>