<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<? if(isset($car_id)): ?>
		<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
		<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>"><?=$username;?></a> <span class="divider">/</span></li>
		<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)));?>"><?=$brand;?> <?=$model;?> (<?=$type;?>)</a> <span class="divider">/</span></li>
	<? else: ?>
		<li><a href="<?=site_url('cars');?>">Auto's</a> <span class="divider">/</span></li>
	<? endif; ?>
	<li class="active">Auto <?=(isset($car_id) ? 'bewerken' : 'toevoegen');?></li>
</ul>
<h1>Auto <?=(isset($car_id) ? 'bewerken' : 'toevoegen');?></h1>
<hr>
<?=form_open('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=form_error('label') ? ' error' : '';?>">
		<label class="control-label" for="label">Label</label>
		<div class="controls">
			<input type="text" id="label" name="label" placeholder="Label" value="<?=set_value('label',(isset($label) ? $label : '')); ?>">
			<span class="help-inline"><?=(form_error('label') ?: 'Bijvoorbeeld: Huidige auto of vorige auto'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('brand') ? ' error' : '';?>">
		<label class="control-label" for="brand">Merk</label>
		<div class="controls">
			<input type="text" id="brand" name="brand" placeholder="Merk" autocomplete="off" value="<?=set_value('brand',(isset($brand) ? $brand : '')); ?>">
			<span class="help-inline"><?=form_error('brand'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('model') ? ' error' : '';?>">
		<label class="control-label" for="model">Model</label>
		<div class="controls">
			<input type="text" id="model" name="model" placeholder="Model" autocomplete="off" value="<?=set_value('model',(isset($model) ? $model : '')); ?>">
			<span class="help-inline"><?=(form_error('model') ?: 'Graag de officiële model benaming invoeren (en uitvoering hieronder)'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('type') ? ' error' : '';?>">
		<label class="control-label" for="type">Uitvoering</label>
		<div class="controls">
			<input type="text" id="type" name="type" placeholder="Uitvoering" autocomplete="off" value="<?=set_value('type',(isset($type) ? $type : '')); ?>">
			<span class="help-inline"><?=form_error('type'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('year') ? ' error' : '';?>">
		<label class="control-label" for="year">Bouwjaar</label>
		<div class="controls">
			<select id="year" name="year">
				<option value="0">Selecteer...</option>
				<? for($i = date('Y'); $i >= 1950; $i--): ?>
					<option value="<?=$i;?>"<?=set_select('year',$i,(isset($year) AND $year == $i ? TRUE : FALSE));?>><?=$i;?></option>
				<? endfor; ?>
			</select>
			<span class="help-inline"><?=form_error('year'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('color') ? ' error' : '';?>">
		<label class="control-label" for="color">Kleur</label>
		<div class="controls">
			<select id="color" name="color">
				<option value="0">Selecteer...</option>
				<? foreach($colors as $color): ?>
					<option value="<?=$color->color_id;?>"<?=set_select('color',$color->color_id,(isset($color_id) AND $color_id == $color->color_id ? TRUE : FALSE));?>><?=$color->color;?></option>
				<? endforeach; ?>
			</select>
			<span class="help-inline"><?=form_error('color'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('description') ? ' error' : '';?>">
		<label class="control-label" for="description">Omschrijving</label>
		<div class="controls">
			<textarea name="description" id="description" placeholder="Omschrijving"><?=set_value('description',(isset($description) ? $description : '')); ?></textarea>
			<span class="help-inline"><?=form_error('description'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('specs') ? ' error' : '';?>">
		<label class="control-label" for="specs">Specificaties</label>
		<div class="controls">
			<textarea name="specs" id="specs" placeholder="Specificaties"><?=set_value('specs',(isset($specs) ? $specs : "**Motorisch\n\n**Uitlaat\n\n**Exterieur\n\n**Banden & Velgen\n\n**Elektronica\n\n**Interieur\n\n**Overig")); ?></textarea>
			<span class="help-inline"><?=(form_error('specs') ?: 'Set elke specificatie op een eigen regel. Categorieën kunnen gemaakt worden door middel van ** voor de naam'); ?></span>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> <?=(isset($car_id) ? 'Bewerken' : 'Toevoegen');?></button>
			<?=(isset($car_id) ? '<a href="'.site_url('delete/car/'.$car_id).'" class="btn btn-danger confirm"><i class="icon-remove icon-white"></i> Auto verwijderen</a>' : '');?>
		</div>
	</div>
</form>