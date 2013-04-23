<? if($mode=="index"): ?>
<h2>Categories</h2>
<table class="table">
    <tr class="header">
	<td style="width:420px;">Nazwa</td>
	<td style="width:25px;">Widoczny</td>
	<td style="width:33px;">Akcja</td>
    </tr>

    <? foreach ($categories as $key=>$category): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    <?= $category->name ?>
	</td>
	<td>
	    <?= ($category->visible==true)?('<img src="data/icons/flag-green.png" alt=""/>'):('<img src="data/icons/flag-black.png" alt=""/>') ?>
	</td>
	<td>
	    <a href="admin/blog_categories/edit/<?= $category->id ?>"><img src="data/icons/document-edit.png" alt="Edit"/></a>
	    <a href="admin/blog_categories/up/<?= $category->id ?>"><img src="data/icons/arrow-up.png" alt="Up"/></a>
	    <br/>
	    <a onClick="return confirm('Usunąć?');" href="admin/blog_categories/remove/<?= $category->id ?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	    <a href="admin/blog_categories/down/<?= $category->id ?>"><img src="data/icons/arrow-down.png" alt="Down"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($categories)%2==0)?("class=\"highlight\""):("") ?> colspan="3" style="text-align:right;">
	    <a href="admin/blog_categories/add"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>


<? endif ?>

<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" action="admin/blog_categories/edit/<?= $category->id ?>">
    <input type="hidden" name="id" value="<?= $category->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Tytuł:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $category->title ?>" name="title"/></td>
	   
	</tr>
	<tr>
	    <td>Nazwa:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $category->name ?>" name="name"/></td>
	</tr>
	<tr>
	    <td>Widoczność:</td>
	    <td><input type="checkbox" name="visible" <?= ($category->visible==1)?'checked="checked"':'' ?> value="visible" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/blog_categories/"><input type="button" value="wróć"></a>
	    </td>
	</tr>
    </table>
</form>
<? endif ?>