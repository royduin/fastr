<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>"><?=$username;?></a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)));?>"><?=$brand;?> <?=$model;?> (<?=$type;?>)</a> <span class="divider">/</span></li>
	<? if(isset($update_id)): ?>
		<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)).'/update/'.$update_id.'/'.url_title(e($title)));?>">Update: <?=e($title);?></a> <span class="divider">/</span></li>
	<? endif; ?>
	<li class="active">Foto's toevoegen</li>
</ul>
<h1>Foto's toevoegen</h1>
<hr>
<?=$error ?: '<div class="alert">Je kan meerdere bestanden selecteren! Bestanden met de volgende extensies kunnen geupload worden: gif, png, jpg, jpeg, bmp, jpe, tiff en tif van maximaal 5MB groot. Er kan maximaal 30MB in één keer geupload worden.</div>';?>

<?=form_open_multipart('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=$error ? ' error' : '';?>">
		<label class="control-label" for="file">Foto's</label>
		<div class="controls">
			<input type="file" id="file" name="userfile[]" multiple>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Uploaden</button>
		</div>
	</div>
</form>