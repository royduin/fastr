<div class="row">
	<div class="span4">
		<img src="<?=site_url('img/icons/car.png');?>" alt="">
	</div>
	<div class="span8 home-item">
		<h2>Maak een profiel voor je auto</h2>
		<p>Een online showroom voor je auto waarbij eenvoudig foto's, specificaties en updates toegevoegd kunnen worden.</p>
		<a class="btn btn-primary btn-large" href="<?=site_url('register');?>">Maak een account &raquo;</a>
	</div>
</div>

<div class="row">
	<div class="span8 home-item">
		<h2>Wordt lid van een club</h2>
		<p>Als lid van een club kan je alle club evenementen en auto's van club leden bekijken.</p>
		<a class="btn btn-primary btn-large" href="<?=site_url('clubs');?>">Bekijk clubs &raquo;</a>
	</div>
	<div class="span4">
		<img src="<?=site_url('img/icons/club.png');?>" alt="">
	</div>
</div>

<div class="row">
	<div class="span4">
		<img src="<?=site_url('img/icons/calendar.png');?>" alt="">
	</div>
	<div class="span8 home-item">
		<h2>Ga naar evenementen</h2>
		<p>Meld je aan bij evenementen waar je naar toe gaat en organiseer een rit erheen met bekenden.</p>
		<a class="btn btn-primary btn-large" href="<?=site_url('events');?>">Bekijk evenementen &raquo;</a>
	</div>
</div>

<div class="row">
	<div class="span8 home-item">
		<h2>Auto profiel delen</h2>
		<p>Een automatisch gegenereerde afbeelding met daarop alle ingevoerde gegevens om te delen op bijvoorbeeld een forum.</p>
		<a class="btn btn-primary btn-large" href="<?=site_url('register');?>">Maak een account &raquo;</a>
	</div>
	<div class="span4">
		<img src="<?=site_url('img/icons/paper.png');?>" alt="">
	</div>
</div>

<? if(!logged_in() AND !user('modal')): ?>
	<div class="modal hide fade" id="welcomeModal">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Welkom bij <?=site_name();?>!</h3>
		</div>
		<div class="modal-body">
			<p><?=site_descr();?></p>
			<p>Help <?=site_name();?> om met dit platform door te gaan door simpelweg een account aan te maken en je auto toe te voegen. Mocht je hierna nog meer willen helpen: vraag anderen dit ook te doen en deel je auto op andere websites!</p>
			<p>Als dank zal deze mededeling niet meer getoond worden :)</p>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn btn-primary"><i class="icon-remove icon-white"></i> Sluiten</button>
		</div>
	</div>
<? endif; ?>