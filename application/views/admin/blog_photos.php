<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" enctype="multipart/form-data" action="admin/blog_photos/edit/<?= $photo->id ?>">
    <input type="hidden" name="id" value="<?= $photo->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Opis:</td>
	    <td><input class="text" style="width:100%;" type="text" value="<?= $photo->title ?>" name="title"/></td>
	</tr>
	<tr>
	    <td>URL:</td>
	    <td colspan="2"><input class="text" style="width:100%;" type="text" value="<?= $photo->url ?>" name="url"/></td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/blog_notes/edit/<?= $photo->note_id ?>"><input type="button" value="wróć"></a>
	    </td>
	</tr>
    </table>
</form>
<? endif ?>