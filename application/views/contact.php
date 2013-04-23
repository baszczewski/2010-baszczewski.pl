<form id="contact" method="post" action="kontakt">
    <table style="text-align: left; width: 100%;">
	<tr>
	    <td></td>
	    <td>
		<div style="height:100px;">
		    <h2>Kontakt</h2><br/>
		    email: <span id="mail">...</span><br/>
		    skype: <span id="skype">...</span><br/>
		    telefon: <span id="phone">...</span>
		</div>
	    </td>
	</tr>
	<tr>
	    <td></td>
	    <td>
		<?php 
		switch (isset($send)?$send:0)
		{
			case 1:
				echo '<h2>Wysłano</h2>';
				break;
			case -1:
				echo '<h2>Problem</h2>Pamiętałeś o konfiguracji SMTP? Bez niej formularz nie zadziała.';
				break;	
			default:
				echo '<h2>Formularz kontaktowy</h2>';
		}
		?>
		&nbsp;<br/>
	    </td>
	</tr>
	<tr>
	    <td style="text-align:right;width:240px;">Imię i nazwisko:</td>
	    <td><input style="width:230px;" class="text" type="text" value="<?= $name ?>" name="name"/></td>
	    </tr>
    	<tr>
	    <td style="text-align:right;">E-mail:</td>
	    <td><input style="width:230px;" class="text" type="text" value="<?= $email ?>" name="email"/></td>
	</tr>
	<tr>
	    <td style="text-align:right;">Tekst:</td>
	    <td>
		<textarea rows="6" class="text" cols="6" style="width:230px;" id="text" name="text"><?= isset($text)?$text:'' ?></textarea>
	    </td>
    	</tr>
	<tr>
	    <td></td>
	    <td>
		<input type="submit" value="Wyślij" />
	    </td>
	</tr>
    </table>
</form>