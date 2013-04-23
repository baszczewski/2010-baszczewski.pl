<? if($mode=="index"): ?>
<h2>Blogroll</h2>
<table class="table">
    <tr class="header">
	<td style="width:210px;">Tytuł</td>
	<td style="width:210px;">Adres</td>
	<td style="width:25px;">Widoczność</td>
	<td style="width:33px;">Akcja</td>
    </tr>

    <? foreach ($links as $key=>$link): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $link->title ?>
	</td>
	<td>
	    <?= $link->url ?>
	</td>
	<td>
	    <?= ($link->visible==true)?('<img src="data/icons/flag-green.png" alt=""/>'):('<img src="data/icons/flag-black.png" alt=""/>') ?>
	</td>
	<td>
	    <a href="admin/blog_blogroll/edit/<?= $link->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a href="admin/blog_blogroll/up/<?= $link->id ?>"><img src="data/icons/arrow-up.png" alt="Up"/></a>
	    <br/>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_blogroll/remove/<?= $link->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	    <a href="admin/blog_blogroll/down/<?= $link->id ?>"><img src="data/icons/arrow-down.png" alt="Down"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($links)%2==0)?("class=\"highlight\""):("") ?> colspan="4" style="text-align:right;">
	    <a href="admin/blog_blogroll/add"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>

<? endif ?>

<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" action="admin/blog_blogroll/edit/<?= $link->id ?>">
    <input type="hidden" name="id" value="<?= $link->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Tytuł:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $link->title ?>" name="title"/></td>
	</tr>
	<tr>
	    <td>Adres:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $link->url ?>" name="url"/></td>
	</tr>
	<tr>
	    <td>Widoczność:</td>
	    <td><input type="checkbox" name="visible" <?= ($link->visible==1)?'checked="checked"':'' ?> value="visible" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/blog_blogroll/"><input type="button" value="wróć"></a>
	    </td>
	</tr>
    </table>
</form>
<? endif ?>