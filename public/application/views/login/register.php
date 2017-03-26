<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Registeren bij <?=config_item('website_name');?></li>
</ul>
<h1>Registeren bij <?=config_item('website_name');?></h1>
<hr>
<?=form_open('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=form_error('username') ? ' error' : '';?>">
		<label class="control-label" for="username">Gebruikersnaam</label>
		<div class="controls">
			<input type="text" id="username" name="username" placeholder="Gebruikersnaam" value="<?=set_value('username',(isset($username) ? $username : '')); ?>">
			<span class="help-inline"><?=form_error('username'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('email') ? ' error' : '';?>">
		<label class="control-label" for="email">Email adres</label>
		<div class="controls">
			<input type="email" id="email" name="email" placeholder="Email adres" value="<?=set_value('email',(isset($email) ? $email : '')); ?>">
			<span class="help-inline"><?=form_error('email'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('password') ? ' error' : '';?>">
		<label class="control-label" for="password">Wachtwoord</label>
		<div class="controls">
			<input type="password" id="password" name="password" placeholder="Wachtwoord" value="<?=set_value('password'); ?>">
			<span class="help-inline"><?=form_error('password'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('password2') ? ' error' : '';?>">
		<label class="control-label" for="password2">Wachtwoord herhalen</label>
		<div class="controls">
			<input type="password" id="password2" name="password2" placeholder="Wachtwoord herhalen" value="<?=set_value('password2'); ?>">
			<span class="help-inline"><?=form_error('password2'); ?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Registreren</button>
		</div>
	</div>
</form>
<div class="alert">Heb je al een account? <a href="<?=site_url('login');?>">Log dan in</a>. In het geval dat je je wachtwoord vergeten bent, <a href="<?=site_url('lostpw');?>">klik dan hier</a>.</div>