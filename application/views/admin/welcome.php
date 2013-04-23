<h2>Kohana</h2>
<table class="table">
    <tr>
	<td style="width:180px;" class="header">Kohana:</td><td>{kohana_version} ({kohana_codename})</td>
    </tr>
    <tr>
	<td class="header">Wyświetlaj błędy:</td><td><?= (Kohana::config('config.display_errors')==1)?"<span style='color:#ff0000;font-weight:bold;'>tak</span>":"nie"; ?></td>
    </tr>
</table>