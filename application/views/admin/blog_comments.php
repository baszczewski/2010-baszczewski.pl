<? if($mode=="edit"): ?>
<h2>Edycja</h2>
<form id="contact" method="post" action="admin/blog_comments/edit/<?= $comment->id ?>">
    <input type="hidden" name="id" value="<?= $comment->id ?>"/>
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td>Login:</td>
	    <td><input type="text" value="<?= $comment->user ?>" name="user"/></td>
	</tr>
	<tr>
	    <td>Data:</td>
	    <td><input type="text" value="<?= $comment->date ?>" name="date"/></td>
	</tr>
	<tr>
	    <td>System:</td>
	    <td><input type="text" value="<?= $comment->system ?>" name="system"/></td>
	</tr>
	<tr>
	    <td>Treść:</td>
	    <td>
		<textarea rows="6" cols="6" style="width:300px;" name="text"><?= $comment->text ?></textarea>
	    </td>
	</tr>
	<tr>
	    <td>Active:</td>
	    <td><input type="checkbox" name="active" <?= ($comment->active==1)?'checked="checked"':'' ?> value="active" /></td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="zapisz" />
		<a href="<?= url::base() ?>admin/blog_notes/edit/<?= $comment->note_id ?>"><input type="button" value="powrót"></a>
	    </td>
	</tr>
    </table>
</form>
<? endif ?>