<? if($mode=="index"): ?>
<h2>Wpisy</h2>
<table class="table">
    <tr class="header">
	<td>Title</td>
	<td style="width:210px;">Nazwa</td>
	<td style="width:25px;">Widoczność</td>
	<td style="width:33px;">Akcja</td>
    </tr>

    <? foreach ($notes as $key=>$note): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $note->title ?>
	</td>
	<td>
	    <?= $note->name ?>
	</td>
	<td>
	    <?= ($note->visible==true)?('<img src="data/icons/flag-green.png" alt=""/>'):('<img src="data/icons/flag-black.png" alt=""/>') ?>
	</td>
	<td>
	    <a href="admin/blog_notes/edit/<?= $note->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_notes/remove/<?= $note->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($notes)%2==0)?("class=\"highlight\""):("") ?> colspan="4" style="text-align:right;">
	    <a href="admin/blog_notes/add"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>
<? endif ?>

<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" action="admin/blog_notes/edit/<?= $note->id ?>">
    <input type="hidden" name="id" value="<?= $note->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Tytuł:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $note->title ?>" name="title"/></td>
	</tr>
	<tr>
	    <td>Nazwa:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $note->name ?>" name="name"/></td>
	</tr>
	<tr>
	    <td>Opis:</td>
	    <td colspan="2">
		<textarea class="text" style="width:100%;" rows="6" cols="6" style="width:300px;" name="description"><?= $note->description ?></textarea>
	    </td>
	</tr>
	<tr>
	    <td>Tekst:</td>
	    <td colspan="2">
		<textarea class="text" style="width:100%;" rows="19" cols="6" style="width:300px;" name="text"><?= $note->text ?></textarea>
	    </td>
	</tr>
	<tr>
	    <td>Data:</td>
	    <td colspan="2"><input class="text" style="width:100%;" type="text" value="<?= $note->date ?>" name="date"/></td>
	</tr>
	<tr>
	    <td>Ocena:</td>
	    <td colspan="2"><input class="text" style="width:100%;" type="text" value="<?= $note->rating ?>" name="rating"/></td>
	</tr>
	<tr>
	    <td>Ilość ocen:</td>
	    <td colspan="2"><input class="text" style="width:100%;" type="text" value="<?= $note->rating_count ?>" name="rating_count"/></td>
	</tr>
	<tr>
	    <td>Widoczność:</td>
	    <td><input type="checkbox" name="visible" <?= ($note->visible==1)?'checked="checked"':'' ?> value="visible" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/blog_notes/"><input type="button" value="wróć"></a>
	    </td>
	</tr>
    </table>
</form>
<br/>
<h2>Kategorie</h2>
<table class="table">
    <tr class="header">
	<td style="width:50%;">Wybrane</td>
	<td style="width:50%;">Dostępne</td>
    </tr>
    <tr>
	<td><? foreach($categories1 as $key=>$tag): ?><?= ($key>0)?', ':''; ?><a href="admin/blog_notes/remove_category/<?= $note->id ?>/<?= $tag->id ?>"><?= $tag->title; ?></a><? endforeach; ?></td>
	<td><? foreach($categories2 as $key=>$tag): ?><?= ($key>0)?', ':''; ?><a href="admin/blog_notes/insert_category/<?= $note->id ?>/<?= $tag->id ?>"><?= $tag->title; ?></a><? endforeach; ?></td>
    </tr>
</table>
<br/>
<h2>Tagi</h2>
<table class="table">
    <tr class="header">
	<td style="width:50%;">Wybrane</td>
	<td style="width:50%;">Dostępne</td>
    </tr>
    <tr>
	<td><? foreach($tags1 as $key=>$tag): ?><?= ($key>0)?', ':''; ?><a href="admin/blog_notes/remove_tag/<?= $note->id ?>/<?= $tag->id ?>"><?= $tag->title; ?></a><? endforeach; ?></td>
	<td><? foreach($tags2 as $key=>$tag): ?><?= ($key>0)?', ':''; ?><a href="admin/blog_notes/insert_tag/<?= $note->id ?>/<?= $tag->id ?>"><?= $tag->title; ?></a><? endforeach; ?></td>
    </tr>
</table>
<br/>
<h2>Komentarze</h2>
<table class="table">
    <tr class="header">
	<td style="width:130px;">Login</td>
	<td>Tekst</td>
	<td style="width:33px;">Akcja</td>
    </tr>
    <? foreach ($comments as $key=>$comment): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= ($comment->user=="")?"Marcin Baszczewski":$comment->user ?>
	</td>
	<td>
	    <?= $comment->text ?>
	</td>
	<td>
	    <a href="admin/blog_comments/edit/<?= $comment->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_comments/remove/<?= $comment->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($photos)%2==0)?("class=\"highlight\""):("") ?> colspan="4" style="text-align:right;">
	    <a href="admin/blog_comments/add/<?= $note->id ?>"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>
<br/><br/>
<h2>Zdjęcia</h2>
<table class="table">
    <tr class="header">
	<td style="width:445px;">Opis</td>
	<td style="width:33px;">Akcja</td>
    </tr>
    <? foreach ($photos as $key=>$photo): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $photo->title ?>
	</td>
	<td>
	    <a href="admin/blog_photos/edit/<?= $photo->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_photos/remove/<?= $photo->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($photos)%2==0)?("class=\"highlight\""):("") ?> colspan="2" style="text-align:right;">
	    <a href="admin/blog_photos/add/<?= $note->id ?>"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>


<br/><br/>
<h2>Pliki</h2>
<table class="table">
    <tr class="header">
	<td style="width:445px;">Opis</td>
	<td style="width:33px;">Akcja</td>
    </tr>

    <? foreach ($files as $key=>$file): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $file->title ?>
	</td>
	<td>
	    <a href="admin/blog_files/edit/<?= $file->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_files/remove/<?= $file->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($files)%2==0)?("class=\"highlight\""):("") ?> colspan="2" style="text-align:right;">
	    <a href="admin/blog_files/add/<?= $note->id ?>"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>
<? endif ?>