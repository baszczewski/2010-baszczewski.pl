<? if($mode=="index"): ?>
<h2>Strony</h2>

<table class="table">
    <tr class="header">
	<td>Nazwa</td>
	<td style="width:25px;">Widoczność</td>
	<td style="width:33px;">Akcja</td>
    </tr>
    <? foreach ($pages as $key=>$page): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $page->name ?>
	</td>
	<td>
	    <?= ($page->visible==true)?('<img src="data/icons/flag-green.png" alt=""/>'):('<img src="data/icons/flag-black.png" alt=""/>') ?>
	</td>
	<td>
	    <a href="admin/cms_pages/edit/<?= $page->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a href="admin/cms_pages/up/<?= $page->id ?>"><img src="data/icons/arrow-up.png" alt="Up"/></a>
	    <br/>
	    <a onClick="return confirm('Usunąć?');" href="admin/cms_pages/remove/<?= $page->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	    <a href="admin/cms_pages/down/<?= $page->id ?>"><img src="data/icons/arrow-down.png" alt="Down"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($pages)%2==0)?("class=\"highlight\""):("") ?> colspan="3" style="text-align:right;">
	    <a href="admin/cms_pages/add"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>

<? endif ?>

<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" action="admin/cms_pages/edit/<?= $page->id ?>">
    <input type="hidden" name="id" value="<?= $page->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Tytuł:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $page->title ?>" name="title"/></td>
	</tr>
	<tr>
	    <td>Nazwa:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $page->name ?>" name="name"/></td>
	</tr>
	<tr>
	    <td>Opis:</td>
	    <td colspan="2">
		<textarea class="text" rows="3" cols="6" style="width:100%;" name="description"><?= $page->description ?></textarea>
	    </td>
	</tr>
	<tr>
	    <td>Tekst:</td>
	    <td colspan="2">
		<textarea class="text" rows="19" cols="6" style="width:100%;" name="text"><?= $page->text ?></textarea>
	    </td>
	</tr>
	<tr>
	    <td>Słowa kluczowe:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $page->keywords ?>" name="keywords"/></td>
	</tr>
	<tr>
	    <td>Tło:</td>
	    <td colspan="2"><input class="text" style="width:100%;" type="text" value="<?= $page->background ?>" name="background"/></td>
	</tr>
	<tr>
	    <td>Kategoria:</td>
	    <td colspan="2">
		<select name="category_id">
		    <? foreach ($categories as $category): ?>
			<option <?= ( ($category->id==$page->category_id)?"selected=\"yes\"":"") ?> value="<?= $category->id ?>"><?= $category->title ?></option>
			<?= $category->title ?><br/>
		    <? endforeach ?>
		</select>
	    </td>
	</tr>
	<tr>
	    <td>URL:</td>
	    <td colspan="2"><input type="checkbox" name="url" <?= ($page->url==1)?'checked="checked"':'' ?> value="url" /></td>
	</tr>
	<tr>
	    <td>Widoczność:</td>
	    <td colspan="2"><input type="checkbox" name="visible" <?= ($page->visible==1)?'checked="checked"':'' ?> value="visible" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td colspan="2">
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/cms_pages/"><input type="button" value="wróć"></a>
	    </td>
	</tr>
    </table>
</form>
<? endif ?>