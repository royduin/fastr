<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>"><?=$username;?></a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)));?>"><?=$brand;?> <?=$model;?> (<?=$type;?>)</a> <span class="divider">/</span></li>
	<? if(isset($update_id)): ?>
		<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)).'/update/'.$update_id.'/'.url_title(e($title)));?>">Update: <?=e($title);?></a> <span class="divider">/</span></li>
	<? endif;?>
	<li class="active">Update <?=(isset($update_id) ? 'bewerken' : 'toevoegen');?></li>
</ul>
<h1>Update <?=(isset($update_id) ? 'bewerken' : 'toevoegen');?></h1>
<hr>
<?=form_open('',['class' => 'form-horizontal']);?>
	<div class="control-group<?=form_error('title') ? ' error' : '';?>">
		<label class="control-label" for="title">Titel</label>
		<div class="controls">
			<input type="text" id="title" name="title" placeholder="Titel" value="<?=set_value('title',(isset($title) ? $title : '')); ?>">
			<span class="help-inline"><?=form_error('title'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('date') ? ' error' : '';?>">
		<label class="control-label" for="date">Datum</label>
		<div class="controls">
			<input type="date" id="date" name="date" placeholder="Datum" value="<?=set_value('date',(isset($date) ? $date : date('Y-m-d'))); ?>">
			<span class="help-inline"><?=form_error('date'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('description') ? ' error' : '';?>">
		<label class="control-label" for="description">Omschrijving</label>
		<div class="controls">
			<textarea name="description" id="description" placeholder="Omschrijving"><?=set_value('description',(isset($description) ? $description : '')); ?></textarea>
			<span class="help-inline"><?=form_error('description'); ?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> <?=(isset($update_id) ? 'Bewerken' : 'Toevoegen');?></button>
			<?=(isset($update_id) ? '<a href="'.site_url('delete/update/'.$update_id).'" class="btn btn-danger confirm"><i class="icon-remove icon-white"></i> Update verwijderen</a>' : '');?>
		</div>
	</div>
</form>