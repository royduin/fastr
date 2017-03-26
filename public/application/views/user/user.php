<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('user');?>">Gebruikers</a> <span class="divider">/</span></li>
	<li class="active"><?=e($username);?></li>
</ul>
<h1>Auto profiel van <?=e($username);?></h1>
<hr>
<? if($visible >= 1 AND !logged_in()): ?>
	<div class="alert alert-error">Dit profiel is enkel zichtbaar voor ingelogde gebruikers.</div>
<? else: ?>
	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('profile');?>" class="btn btn-primary pull-right tip" title="Profiel bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>
	<h2>Algemeen</h2>
	<div class="row">
		<div class="span10">
			<table class="table table-striped table-bordered table-hover">
				<tr>
					<th><?=site_name();?> gebruikers ID</th>
					<td><?=$user_id;?></td>
				</tr>
				<tr>
					<th>Woonplaats</th>
					<td><?=$city ? e($city) : 'Niet opgegeven';?></td>
				</tr>
				<tr>
					<th>Website</th>
					<td><?=$website ? '<a href="'.e($website).'" target="_blank">'.e($website).'</a>' : 'Niet opgegeven';?></td>
				</tr>
				<tr>
					<th>Geboorte datum</th>
					<td><?=$birth ? date('d-m-Y',strtotime($birth)).', dus '.age($birth).' jaar oud'.(date('d-m') == date('d-m',strtotime($birth)) ? ' en <strong>vandaag jarig!</strong>' : '') : 'Niet opgegeven';?></td>
				</tr>
				<tr>
					<th><?=site_name();?> lid sinds</th>
					<td><?=$registered != '0000-00-00 00:00:00' ? date('d-m-Y',strtotime($registered)) : 'Onbekend';?></td>
				</tr>
				<tr>
					<th>Contact</th>
					<td><a href="#">Stuur email</a></td>
				</tr>
			</table>	
		</div>
		<div class="span2">
			<img src="//www.gravatar.com/avatar/<?=md5(strtolower(trim($email)));?>?s=140&d=<?=urlencode(site_url('img/geen-foto.png'));?>" alt="Avatar van <?=$username;?>" class="img-polaroid pull-right" width="140">
		</div>
	</div>
	<? if($user_id == user('user_id')): ?>
		<a href="<?=site_url('profile');?>" class="btn btn-primary pull-right tip" title="Omschrijving bewerken"><i class="icon-edit icon-white"></i></a>
	<? endif; ?>

	<h2>Omschrijving</h2>
	<?=$description ? '<p class="well">'.e($description).'</p>' : '<div class="alert alert-error">'.e($username).' heeft geen omschrijving opgegeven</div>'; ?>
	
	<h2>Clubs</h2>
	<? if(empty($clubs)): ?>
		<div class="alert alert-error"><?=e($username);?> is nog geen lid bij een club</div>
	<? else: ?>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<? foreach($clubs as $club): ?>
					<td class="span3"><img src="<?=site_url(isset(glob('img/clubs/'.$club->club_id.'/logo.*')[0]) ? glob('img/clubs/'.$club->club_id.'/logo.*')[0] : 'img/geen-foto.png');?>" alt="<?=e($club->name);?> logo" width="170"></td>
					<td class="span9"><a href="<?=site_url('clubs/'.$club->club_id.'/'.url_title(e($club->name)));?>" class="tip" title="Ga naar de <?=site_name();?> club pagina van <?=e($club->name);?>"><?=$club->name;?></a></td>
				<? endforeach;?>
			</tr>
		</table>
	<? endif;?>

	<h2>Auto's</h2>
	<? if(!$cars): ?>
		<div class="alert alert-error"><?=e($username);?> heeft nog geen auto's</div>
	<? else: ?>
		<div class="row-fluid">
			<ul class="thumbnails">
				<? foreach($cars as $car): ?>
					<? $car_url = site_url('user/'.$user_id.'/'.url_title(e($username)).'/car/'.$car->car_id.'/'.url_title(e($car->brand).' '.e($car->model).' '.e($car->type)));?>
					<li class="span3">
						<div class="thumbnail">
							<span class="label label-success label-thumb"><?=e($car->label);?></span>
							<a href="<?=$car_url;?>"><img src="<?=thumb($car->image_default,260,260);?>" alt="<?=e($car->brand);?> <?=e($car->model);?> (<?=e($car->type);?>)"></a>
							<h3 class="fittext"><a href="<?=$car_url;?>"><?=e($car->brand);?> <?=e($car->model);?></a></h3>
							<p><?=e($car->type);?> uit <?=e($car->year);?></p>
						</div>
					</li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endif;?>
	<h2>Reacties</h2>
	<? $this->load->view('comments',['what' => 'user','id' => $user_id]); ?>
<? endif; ?>
