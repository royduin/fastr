<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)));?>"><?=e($username);?></a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)));?>"><?=e($brand);?> <?=e($model);?> (<?=e($type);?>)</a> <span class="divider">/</span></li>
	<li class="active">Update: <?=e($title);?></li>
</ul>
<? if($visible >= 1 AND !logged_in()): ?>
<? else: ?>
	<span class="label label-success pull-right"><?=date('d-m-Y',strtotime($date));?></span>
<? endif; ?>
<h1>Update: <?=e($title);?></h1>
<hr>
<? if($visible >= 1 AND !logged_in()): ?>
	<div class="alert alert-error">Deze update is enkel zichtbaar voor ingelogde gebruikers.</div>
<? else: ?>
	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('add-edit/update/'.$car_id.'/'.$update_id);?>" class="btn btn-primary pull-right tip" title="Update bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>
	
	<h2>Omschrijving</h2>
	<p class="well">
		<?=nl2br(e($description));?>
	</p>
	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('add-edit/photo/'.$car_id.'/'.$update_id);?>" class="btn btn-primary pull-right tip" title="Foto's toevoegen"><i class="icon-plus icon-white"></i></a>
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
		<? $image 	= site_url('share/update/'.$update_id.'/'.$hash.'/image');?>
		<? $url 	= site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car_id.'/'.url_title(e($brand).' '.e($model).' '.e($type)).'/update/'.$update_id.'/'.url_title(e($title)));?>
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
	<? $this->load->view('comments',['what' => 'update','id' => $update_id]); ?>
<? endif; ?>