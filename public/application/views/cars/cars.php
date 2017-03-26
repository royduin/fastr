<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Auto's</li>
</ul>
<a href="<?=site_url('add-edit/car');?>" class="btn btn-primary pull-right"><i class="icon-plus icon-white"></i> Auto toevoegen</a>
<h1>Auto's</h1>
<hr>
<div class="row">
	<div class="span2">
		<h2>Filters</h2>
		<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
		<?=form_open('',['method' => 'get']);?>
			<label for="brand">Merk</label>
			<select name="brand" id="brand" class="span2">
				<option value="">Alle merken</option>
				<? foreach($brands as $brand): ?>
					<option value="<?=e($brand->brand_name);?>"<?=($this->input->get('brand') == e($brand->brand_name) ? ' selected="selected"' : '');?>><?=e($brand->brand_name);?></option>
				<? endforeach;?>
			</select>
			<div id="model-select">
				<label for="model">Model</label>
				<select name="model" id="model" class="span2">
					<option value="">Alle modellen</option>
				</select>
			</div>
			<div id="type-select">
				<label for="type">Uitvoering</label>
				<select name="type" id="type" class="span2">
					<option value="">Alle uitvoeringen</option>
				</select>
			</div>
			<label for="year">Bouwjaar</label>
			<select name="year" id="year" class="span2">
				<option value="">Alle jaren</option>
				<? for($i = date('Y'); $i >= 1950; $i--): ?>
					<option value="<?=$i;?>"<?=($this->input->get('year') == $i ? ' selected="selected"' : '');?>><?=$i;?></option>
				<? endfor; ?>
			</select>
			<label for="color">Kleur</label>
			<select name="color" id="color" class="span2">
				<option value="">Alle kleuren</option>
				<? foreach($colors as $color): ?>
					<option value="<?=$color->color;?>"<?=($this->input->get('color') == $color->color ? ' selected="selected"' : '');?>><?=$color->color;?></option>
				<? endforeach; ?>
			</select>
			<label for="club">Club</label>
			<select name="club" id="club" class="span2">
				<option value="">Alle clubs</option>
				<? foreach($clubs as $club): ?>
					<option value="<?=e($club->name);?>"<?=($this->input->get('club') == e($club->name) ? ' selected="selected"' : '');?>><?=e($club->name);?></option>
				<? endforeach; ?>
			</select>
			<label for="event">Evenement</label>
			<select name="event" id="event" class="span2">
				<option value="">Elk evenement</option>
			</select>
			<label for="specs">Specificaties</label>
			<input type="text" name="specs" id="specs" placeholder="In specificaties zoeken..." class="span2"<?=($this->input->get('specs') ? ' value="'.e($this->input->get('specs')).'"' : '');?>>
			<button class="btn btn-primary btn-small btn-block" type="submit">Filteren</button>
		</form>
	</div>
	<div class="span10">
		<h2>Resultaten</h2>
		<? if(empty($cars)): ?>
			<div class="alert alert-error">Er zijn geen auto's gevonden aan de hand van de opgegeven filters</div>
		<? else: ?>
			<div class="row-fluid">
				<ul class="thumbnails">
					<? foreach($cars as $car): ?>
						<? $car_url = site_url('user/'.$car->user_id.'/'.url_title(e($car->username)).'/car/'.$car->car_id.'/'.url_title(e($car->brand).' '.e($car->model).' '.e($car->type)));?>
						<li class="span3">
							<div class="thumbnail">
								<a href="<?=$car_url;?>"><img src="<?=thumb($car->image_default);?>" alt="<?=$car->brand;?> <?=$car->model;?> (<?=$car->type;?>)"></a>
								<h3 class="fittext"><a href="<?=$car_url;?>"><?=$car->brand;?> <?=$car->model;?></a></h3>
								<p class=""><?=$car->type;?> uit <?=$car->year;?> van <a href="#" title="Ga naar het profiel van <?=$car->username;?>" class="tip"><?=$car->username;?></a></p>
							</div>
						</li>
					<? endforeach; ?>
				</ul>
			</div>
		<? endif;?>
	</div>
</div>