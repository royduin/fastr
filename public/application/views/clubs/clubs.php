<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Clubs</li>
</ul>
<h1>Clubs</h1>
<hr>
<? if(empty($clubs)): ?>
	<div class="alert">Er zijn nog geen clubs</div>
<? else: ?>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<th class="span3">Logo</th>
			<th class="span8">Naam</th>
			<th class="span1"></th>
		</tr>
		<? foreach($clubs as $club): ?>
			<tr>
				<td><img src="<?=site_url(isset(glob('img/clubs/'.$club->club_id.'/logo.*')[0]) ? glob('img/clubs/'.$club->club_id.'/logo.*')[0] : 'img/geen-foto.png');?>" alt="<?=e($club->name);?> logo" width="170"></td>
				<td><a href="<?=site_url('clubs/'.$club->club_id.'/'.url_title(e($club->name)));?>" class="tip" title="Ga naar de <?=site_name();?> club pagina van <?=e($club->name);?>"><?=e($club->name);?></a></td>
				<td>
					<a href="<?=prep_url($club->website);?>" target="_blank" class="btn btn-primary btn-mini tip" title="Website van <?=e($club->name);?> bezoeken"><i class="icon-home icon-white"></i></a>
				</td>
			</tr>
		<? endforeach; ?>
	</table>
<? endif; ?>

<div class="alert">Staat je club er niet tussen of wil je een club aanmelden? Neem dan <a href="<?=site_url('contact');?>">contact</a> op!</div>