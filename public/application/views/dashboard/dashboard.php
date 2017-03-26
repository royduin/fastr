<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Dashboard</li>
</ul>
<a href="<?=site_url('profile');?>" class="btn btn-primary pull-right"><i class="icon-edit icon-white"></i> Profiel bewerken</a>
<h1>Dashboard</h1>
<hr>
<div class="row">
	<div class="span4">
		<a href="<?=site_url('add-edit/car');?>" class="btn btn-primary pull-right tip" title="Auto toevoegen"><i class="icon-plus icon-white"></i></a>
		<h2><a href="<?=site_url('cars');?>">Auto's</a></h2>
		<? if(empty($cars)): ?>
			<div class="alert">Je hebt nog geen auto's toegevoegd</div>
		<? else: ?>
			<ul class="unstyled">
			<? foreach($cars as $car): ?>
				<li><span class="label label-success"><?=e($car->label);?></span> <a href="<?=site_url('user/'.$car->user_id.'/'.url_title(e($car->username)).'/car/'.$car->car_id.'/'.url_title(e($car->brand).' '.e($car->model).' '.e($car->type)));?>" class="tip" title="Ga naar de <?=e($car->brand);?> <?=e($car->model);?>"><?=e($car->brand);?> <?=e($car->model);?> (<?=e($car->type);?>)</a></li>
			<? endforeach; ?>
			</ul>
		<? endif;?>
	</div>
	<div class="span4">
		<a href="<?=site_url('events');?>" class="btn btn-primary pull-right tip" title="Evenementen bekijken"><i class="icon-list icon-white"></i></a>
		<h2><a href="<?=site_url('events');?>">Evenementen</a></h2>
		<div class="alert">Je bent nog niet aangemeld bij een evenement</div>
	</div>
	<div class="span4">
		<a href="<?=site_url('clubs');?>" class="btn btn-primary pull-right tip" title="Clubs bekijken"><i class="icon-list icon-white"></i></a>
		<h2><a href="<?=site_url('clubs');?>">Clubs</a></h2>
		<? if(empty($clubs)): ?>
			<div class="alert">Je bent nog niet aangemeld bij een club</div>
		<? else: ?>
			<ul class="unstyled">
			<? foreach($clubs as $club): ?>
				<li><a href="<?=site_url('clubs/'.$club->club_id.'/'.url_title(e($club->name)));?>" class="tip" title="Ga naar club pagina van <?=e($club->name);?>"><?=$club->name;?></a></li>
			<? endforeach; ?>
			</ul>
		<? endif; ?>
	</div>
</div>
<hr>
<div class="row">
	<div class="span4">
		<h2>Laatste reacties</h2>
		<div class="alert">Je hebt nog nergens een reactie geplaatst</div>
	</div>
	<div class="span8">
		<h2>Auto's volgen</h2>
		<? if(empty($following)): ?>
			<div class="alert">Je volgt nog geen auto's, druk op het oog icoontje (<i class="icon-eye-open"></i>) bij een auto om deze te volgen</div>
		<? else: ?>
			<ul class="media-list">
				<? foreach($following as $follow): ?>
					<? $url_user 	= site_url('user/'.$follow->user_id.'/'.url_title(e($follow->username))); ?>
					<? $url_car 	= $url_user.'/car/'.$follow->car_id.'/'.url_title(e($follow->brand).' '.e($follow->model).' '.e($follow->type)); ?>
					<? $url_update 	= $url_car.'/update/'.$follow->update_id.'/'.url_title(e($follow->update_title)); ?>
					<li class="media">
						<a class="pull-left tip" href="<?=$url_car;?>" title="Ga naar de <?=e($follow->brand);?> <?=e($follow->model);?> van <?=e($follow->username);?>">
							<img src="<?=thumb($follow->image_default,64,64);?>" alt="De <?=e($follow->brand);?> <?=e($follow->model);?> van <?=e($follow->username);?>" class="img-polaroid pull-right" width="64">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=$url_car;?>" class="tip" title="Ga naar de <?=e($follow->brand);?> <?=e($follow->model);?> van <?=e($follow->username);?>">
									<?=e($follow->brand);?> <?=e($follow->model);?> (<?=e($follow->type);?>)
								</a>
							</h4>
							<p>Van <a href="<?=$url_user;?>" class="tip" title="Ga naar het profiel van <?=e($follow->username);?>"><?=e($follow->username);?></a> uit het jaar <?=$follow->year;?><br>Met als label: <?=e($follow->label);?></p>
							<? if($follow->update_id): ?>
								<div class="media">
									<a class="pull-left tip" href="<?=site_url('user/'.$follow->user_id.'/'.url_title(e($follow->username)));?>" title="Ga naar de <?=e($follow->brand);?> <?=e($follow->model);?> van <?=e($follow->username);?>">
										<img src="<?=thumb($follow->update_image,64,64);?>" alt="Avatar van <?=e($follow->username);?>" class="img-polaroid pull-right" width="64">
									</a>
									<div class="media-body">
										<h4 class="media-heading">
											<a href="<?=$url_update;?>">
												Laatste update: <?=e($follow->update_title);?>
											</a>
										</h4>
										<p>Uitgevoerd op <?=date('d-m-Y',strtotime($follow->update_date));?></p>
									</div>
								</div>
							<? endif; ?>
						</div>
					</li>
				<? endforeach;?>
			</ul>
		<? endif; ?>
	</div>
</div>