<? if($mode=="index"): ?>
<h2>Pliki</h2>
<table class="table">
    <tr class="header">
	<td>Nazwa</td>
	<td style="width:17px;">Akcja</td>
    </tr>

    <? foreach ($files as $key=>$file): ?>
    <tr <? if ($key%2==0): ?> class="highlight"<? endif ?> >
	<td>
	    data/upload/<?= $file->date ?>/<?= $file->name ?>
	</td>
	<td style="text-align:right;">
	    <a onClick="return confirm('Usunąć?');" href="admin/cms_files/remove/<?= $file->id?>"><img src="data/icons/list-remove.png" alt="Remove"/></a>
	</td>
    </tr>
    <? endforeach ?>
    <tr>
	<td <?= (count($files)%2==0)?("class=\"highlight\""):("") ?> colspan="2" style="text-align:right;">
	    <a href="admin/cms_files/add"><img src="data/icons/list-add.png" alt=""/></a>
	</td>
    </tr>
</table>
<? endif ?> 

<? if($mode=="add"): ?>
<h2>Nowy plik</h2>
<form id="contact" method="post" enctype="multipart/form-data" action="admin/cms_files/add">
    <select name="type">
	<option value=0 selected>Plik</option>
	<option value=1>Zdjęcie</option>
	<option value=2>Zdjęcie + Miniaturka</option>
    </select>
    <input name="file" type="file" />
    <br/>
    <input type="submit" value="wyślij" />
</form>
<? endif ?> 