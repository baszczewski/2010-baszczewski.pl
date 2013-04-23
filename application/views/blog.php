<? foreach ($notes as $note): ?>
    <div class="date">
	<div class="datestamp">
	    <div>
		<span class="cal1 cal1x"><?= date("d",strtotime($note->date)) ?></span>
		<span class="cal2"><?= date("m",strtotime($note->date)) ?></span>
		<span class="cal3"><?= date("Y",strtotime($note->date)) ?></span>
	    </div>
	</div>
	<div class="title">
	    <h1 style="width:350px;float:left;"><a href="blog/czytaj/<?= $note->name ?>"><?= $note->title ?></a></h1>
	    <div style="float:right;">
		<div class="rating">
		    <div id="rating_<?= $note->id ?>" class="tips" >
			<?php 
				$rating = $note->rating;
				for ($i=0;$i<$rating;$i++)
				echo '<div class="star1"></div>'; 
				for ($i=0;$i<5-$rating;$i++)
				echo '<div class="star2"></div>';
			?>
		    </div>
		</div>
	    </div>
	</div> 

	<div style="float:left;width:450px;">
	    <div>
		Kategoria
		<? foreach($note->categories as $key=>$category): ?><? if($key>0):?>,&nbsp;<? endif ?><a href="blog/kategoria/<?= $category->name ?>"><?= $category->title ?></a><? endforeach ?>
		&nbsp;|&nbsp;
		<a href="blog/czytaj/<?= (($note->name!="")?$note->name:$note->id) ?>#comments"><?= $note->count_comments ?></a> Komentarzy
	 	
		<br/>
		Tagi:  
		<? foreach($note->tags as $key=>$tag): ?><? if($key>0):?>,&nbsp;<? endif ?><a href="blog/tagi/<?= $tag->name ?>"><?= $tag->title ?></a><? endforeach ?>
		
	  </div>
	</div>
    </div>

    <div class="note"><?= $note->text ?></div>



<? if(count($note->photos)>0): ?>
<h2>Galeria</h2><br/>
<div class="photos">
    <? foreach ($note->photos as $photo): ?>
    <a href="<?= $photo->url ?>" rel="lightbox-<?= $note->id ?>" title="<?= $photo->title ?>"><img alt="<?= $photo->title ?>" src="<?= trim($photo->url) ?>.thumb.jpg"/></a>
    <? endforeach; ?>
</div><br/>
<? endif; ?>

<? if(count($note->files)>0): ?>
<h2>Załączniki</h2><br/>
<div class="files">
    <? foreach ($note->files as $file): ?>
    <div><span class="download"></span><a href="<?= $file->url ?>"><?= $file->title ?></a></div>
    <? endforeach; ?>
</div><br/>
<? endif; ?>


<? endforeach; ?>





<? if($show_comments): ?>
<div id="comments">
<h4>
<?= $note->count_comments ?>&nbsp;Komentarzy:
</h4>
<? foreach ($note->comments as $comment): ?>

<? if ( ($comment->active)||(cookie::get('blog-comment-'.$comment->id,false))||($last==$comment->id) ): ?>
<div class="comment" id="comment-<?= $comment->id ?>">
	<span class="login">
	    <? if($comment->user!=''): ?>
		<? if($comment->website!=''): ?>
		    <a rel="external nofollow" href="<?= $comment->website ?>">
		<? endif; ?>
		<b><?= $comment->user ?></b>
		<? if($comment->website!=''): ?>
		    </a>
		<? endif; ?>
	    <? else: ?>
		<a href="<?= url::base() ?>"><b>Marcin Baszczewski</b></a>
	    <? endif; ?>	  
	</span>
	<span class="more"><i><?= date("d-m-Y G:i", strtotime($comment->date))  ?></i>&nbsp;<a href="blog/czytaj/<?= (($note->name!="")?($note->name):($note->id)) ?>#comment-<?= $comment->id ?>">#</a></span>
</div>
<div class="comment-text1">
    <div class="comment-text">
	    <?= $comment->text ?>
	    <? if((!$comment->active)&&((cookie::get('blog-comment-'.$comment->id,false)||($last==$comment->id)))): ?>
	    <div class="inactive">Twój komentarz; ?>.</div>
	    <? endif; ?>
    </div>
</div>
<? endif; ?>

<? endforeach; ?>
<?= (!$send==1)?('<a id="newcomment" href="">Pozostaw komentarz</a>'):''; ?>
<div style="float:left;width: 100%;" id="comment" >
<form <?= (!$send==1)?('style="display:none;"'):('');?> method="post" action="blog/czytaj/<?= $note->id ?>#comment">
	<table style="float:left;text-align: left; margin:30px 0 20px 30px;">
		<tr>
			<td colspan="2">
				<?php 
				switch (isset($send)?$send:0)
				{
					case 1:
						echo '<strong>Dodano</strong>';
						break;
					case -1:
						echo '<strong>Problem</strong>';
						break;	
					default:
						echo '<strong>Pozostaw komentarz</strong>';
				}
				?>
				&nbsp;<br/><br/>
			</td>
		</tr>
    	<tr>
	    <td><input style="width:220px;" class="text" type="text" value="<?php echo isset($name)?$name:'';?>" name="name"/></td>
	    <td style="width:300px;">Imię i nazwisko <span style="color:#ff0000;">*</span></td>
	</tr>
    	<tr>
      		<td><input style="width:220px;" class="text" type="text" value="<?php echo isset($email)?$email:'';?>" name="email"/></td>
      		<td>Email <span style="color:#ff0000;">*</span></td>
	</tr>
    	<tr>
      		<td><input style="width:220px;" class="text" type="text" value="<?php echo isset($website)?$website:'';?>" name="website"/></td>
		<td>Strona</td>
	</tr>
    	<tr>
      		<td colspan="2">
		    <textarea cols="6" rows="6" style="width:440px;" class="text" id="text" name="text"><?php echo isset($text)?$text:'';?></textarea>
      		</td>
    	</tr>
    	<tr>
      		<td colspan="2">
				  <input type="submit" value="wyślij" />
      		</td>
    	</tr>
	</table>
</form>
</div>
</div>
<? endif; ?>

<?php if (isset($pagination)) echo '<div style="text-align:center;">'.$pagination->render().'</div>'; ?>