<? $edit_url = site_url('add-edit/car/'.$car_id);?>
<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>"><?=e($username);?></a> <span class="divider">/</span></li>
	<li class="active"><?=e($brand);?> <?=e($model);?> (<?=e($type);?>)</li>
</ul>
<? if(logged_in() AND $user_id != user('user_id')): ?>
	<? if($following): ?>
		<a href="<?=site_url('delete/follow/'.$car_id);?>" class="btn btn-danger pull-right tip" title="Auto niet meer volgen"><i class="icon-eye-close icon-white"></i></a>
	<? else: ?>
		<a href="<?=site_url('add-edit/follow/'.$car_id);?>" class="btn btn-warning pull-right tip" title="Auto volgen"><i class="icon-eye-open icon-white"></i></a>
	<? endif; ?>
<? endif; ?>
<h1><?=e($brand);?> <?=e($model);?> (<?=e($type);?>)</h1>
<hr>
<? if($visible >= 1 AND !logged_in()): ?>
	<div class="alert alert-error">Deze auto is enkel zichtbaar voor ingelogde gebruikers.</div>
<? else: ?>
	<? if($user_id == user('user_id')): ?>
		<a href="<?=$edit_url;?>" class="btn btn-primary pull-right tip" title="Auto bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>
	<h2>Overzicht</h2>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<th class="span3">Merk</th>
			<td class="span9"><?=e($brand);?></td>
		</tr>
		<tr>
			<th>Model</th>
			<td><?=e($model);?></td>
		</tr>
		<tr>
			<th>Uitvoering</th>
			<td><?=e($type);?></td>
		</tr>
		<tr>
			<th>Bouwjaar</th>
			<td><?=e($year);?></td>
		</tr>
		<tr>
			<th>Kleur</th>
			<td><?=$color ? e($color) : 'Niet opgegeven';?></td>
		</tr>
		<tr>
			<th>Eigenaar</th>
			<td><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>" class="tip" title="Ga naar het profiel van <?=e($username);?>"><?=e($username);?></a></td>
		</tr>
		<tr>
			<th>Label door eigenaar</th>
			<td><?=e($label);?></td>
		</tr>
	</table>

	<? if($user_id == user('user_id')): ?>
		<a href="<?=$edit_url;?>" class="btn btn-primary pull-right tip" title="Omschrijving bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>
	<h2>Omschrijving</h2>
	<? if(!$description): ?>
		<div class="alert alert-error">Er is (nog) geen omschrijving</div>
	<? else: ?>
		<div class="well well-small">
			<?=nl2br(e($description));?>
		</div>
	<? endif; ?>

	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('add-edit/photo/'.$car_id);?>" class="btn btn-primary pull-right tip" title="Foto's toevoegen"><i class="icon-plus icon-white"></i></a>
	<? endif; ?>
	<h2>Foto's</h2>
	<? if(!$images): ?>
		<div class="alert alert-error">Er zijn (nog) geen foto's</div>
	<? else: ?>
		<div class="row-fluid">
			<ul class="thumbnails">
				<? foreach($images as $image): ?>
					<li class="span2">
						<div class="thumbnail">
							<a href="<?=site_url($image);?>" class="fancybox" rel="car">
								<img src="<?=thumb($image);?>" alt="<?=e($brand);?> <?=e($model);?> (<?=e($type);?>)">
							</a>
							<? if($user_id == user('user_id')): ?>
								<a href="<?=site_url('delete/image/'.$image);?>" class="btn btn-mini btn-danger tip confirm" title="Afbeelding verwijderen"><i class="icon-remove icon-white"></i></a>
								<? if($image_default != $image): ?>
									<a href="<?=site_url('add-edit/image_default/'.$image);?>" class="btn btn-mini btn-warning tip pull-right" title="Afbeelding als standaard instellen"><i class="icon-star icon-white"></i></a>
								<? endif; ?>
							<? endif;?>
						</div>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif; ?>

	<? if($user_id == user('user_id')): ?>
		<a href="<?=$edit_url;?>" class="btn btn-primary pull-right tip" title="Specificaties bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>
	<h2>Specificaties</h2>
	<? if(!$specs): ?>
		<div class="alert alert-error">Er zijn (nog) geen specificaties</div>
	<? else: ?>
		<div class="well well-small">
			<?=specs(e($specs));?>
		</div>
	<? endif; ?>

	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('add-edit/update/'.$car_id);?>" class="btn btn-primary pull-right tip" title="Update toevoegen"><i class="icon-plus icon-white"></i></a>
	<? endif; ?>
	<h2>Updates</h2>
	<? if(!$updates): ?>
		<div class="alert alert-error">Er zijn (nog) geen updates</div>
	<? else: ?>
		<div class="row-fluid">
			<ul class="thumbnails">
				<? foreach($updates as $update): ?>
					<? $update_url = site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)).'/update/'.$update->update_id.'/'.url_title(e($update->title))); ?>
					<li class="span2">
						<div class="thumbnail">
							<span class="label label-success label-thumb"><?=date('d-m-Y',strtotime($update->date));?></span>
							<a href="<?=$update_url;?>"><img src="<?=thumb($update->image_default);?>" alt="<?=e($update->title);?>"></a>
							<h3 class="fittext"><a href="<?=$update_url;?>" class="tip" title="<?=e($update->title);?>"><?=max_length(e($update->title),14);?></a></h3>
						</div>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif; ?>

	<? if($user_id == user('user_id')): ?>
		<? $image 	= site_url('share/car/'.$car_id.'/'.$hash.'/image');?>
		<? $url 	= site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)));?>
		<h2>Delen</h2>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th class="span3">Afbeelding</th>
				<td class="span9"><a href="<?=$image;?>" target="_blank"><?=$image;?></a></td>
			</tr>
			<tr>
				<th>Delen op een forum</th>
				<td>
					<textarea>[url=<?=$url;?>][img]<?=$image;?>[/img][/url]</textarea>
				</td>
			</tr>
		</table>
	<? endif;?>

	<h2>Reacties</h2>
	<? $this->load->view('comments',['what' => 'car','id' => $car_id]); ?>
<? endif;?>