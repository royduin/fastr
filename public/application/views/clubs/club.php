<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('clubs');?>">Clubs</a> <span class="divider">/</span></li>
	<li class="active"><?=e($name);?></li>
</ul>

<? if($manager == user('user_id')): ?>
	<a href="<?=site_url('add-edit/club/'.$club_id);?>" class="btn btn-primary pull-right tip" title="Club pagina bewerken"><i class="icon-edit icon-white"></i></a>
<? elseif(logged_in() AND $open == 1 AND !$member): ?>
	<a href="<?=site_url('add-edit/club_member/'.$club_id);?>" class="btn btn-primary pull-right tip" title="Wordt lid van <?=e($name);?>"><i class="icon-check icon-white"></i></a>
<? elseif(logged_in() AND $open == 1 AND $member): ?>
	<a href="<?=site_url('delete/club_member/'.$club_id);?>" class="btn btn-warning pull-right tip" title="Lidmaatschap opzeggen bij <?=e($name);?>"><i class="icon-remove icon-white"></i></a>
<? elseif(logged_in() AND $open != 1): ?>
	<button class="btn btn-danger pull-right tip disabled" title="<?=e($name);?> is een gesloten club. Wil je lid worden? Neem dan contact op met de club"><i class="icon-remove icon-white"></i></button>
<? endif; ?>
<h1><?=e($name);?></h1>
<hr>

<h2>Informatie</h2>
<div class="row">
	<div class="span10">
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th class="span3">Website</th>
				<td class="span9"><a href="<?=prep_url($website);?>" target="_blank" class="tip" title="Website van <?=e($name);?> bezoeken"><?=e($website);?></a></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><a href="mailto:<?=$email;?>" target="_blank" class="tip" title="Email sturen naar <?=e($name);?>"><?=e($email);?></a></td>
			</tr>
			<tr>
				<th>Pagina beheerder</th>
				<td>
					<? $username = $this->db->get_where('users',['user_id' => $manager])->row()->username; ?>
					<a href="<?=site_url('user/'.$manager.'/'.url_title(e($username)));?>" class="tip" title="Ga het profiel van <?=e($username);?>"><?=e($username);?></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="span2">
		<img src="<?=site_url($logo);?>" alt="Logo van <?=e($name);?>" class="img-polaroid pull-right" width="140">
	</div>
</div>

<h2>Omschrijving</h2>
<p class="well"><?=nl2br(e($description));?></p>

<h2>Leden</h2>
<? if(!$members): ?>
	<div class="alert alert-error">Deze club heeft nog geen leden</div>
<? else: ?>
	<ul class="inline well">
		<? foreach($members as $member): ?>
			<li><a href="<?=site_url('user/'.$member->user_id.'/'.url_title(e($member->username)));?>" class="tip" title="Ga naar de profiel pagina van <?=e($member->username);?>"><?=e($member->username);?></a></li>
		<? endforeach;?>
	</ul>
<? endif;?>