<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Inloggen bij <?=config_item('website_name');?></li>
</ul>
<h1>Inloggen bij <?=config_item('website_name');?></h1>
<hr>
<?=form_open('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=form_error('username') ? ' error' : '';?>">
		<label class="control-label" for="username">Gebruikersnaam</label>
		<div class="controls">
			<input type="text" id="username" name="username" placeholder="Gebruikersnaam" value="<?=set_value('username',(isset($username) ? $username : '')); ?>">
			<span class="help-inline"><?=form_error('username'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('password') ? ' error' : '';?>">
		<label class="control-label" for="password">Wachtwoord</label>
		<div class="controls">
			<input type="password" id="password" name="password" placeholder="Wachtwoord" value="<?=set_value('password'); ?>">
			<span class="help-inline"><?=form_error('password'); ?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Inloggen</button>
		</div>
	</div>
</form>
<div class="alert">Heb je nog geen account? <a href="<?=site_url('register');?>">Registreer je gratis</a>! In het geval dat je je wachtwoord vergeten bent, <a href="<?=site_url('lostpw');?>">klik dan hier</a>.</div>