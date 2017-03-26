<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('dashboard');?>">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('profile');?>">Profiel van <?=user('username');?></a> <span class="divider">/</span></li>
	<li class="active">Wachtwoord wijzigen</li>
</ul>
<h1>Wachtwoord wijzigen</h1>
<hr>
<?=form_open('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=form_error('password') ? ' error' : '';?>">
		<label class="control-label" for="password">Huidig wachtwoord</label>
		<div class="controls">
			<input type="password" id="password" name="password" placeholder="Huidig wachtwoord" value="<?=set_value('password'); ?>">
			<span class="help-inline"><?=form_error('password'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('password_new') ? ' error' : '';?>">
		<label class="control-label" for="password_new">Nieuw wachtwoord</label>
		<div class="controls">
			<input type="password" id="password_new" name="password_new" placeholder="Nieuw wachtwoord" value="<?=set_value('password_new'); ?>">
			<span class="help-inline"><?=form_error('password_new'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('password_new2') ? ' error' : '';?>">
		<label class="control-label" for="password_new2">Nieuw wachtwoord herhalen</label>
		<div class="controls">
			<input type="password" id="password_new2" name="password_new2" placeholder="Nieuw wachtwoord herhalen" value="<?=set_value('password_new2'); ?>">
			<span class="help-inline"><?=form_error('password_new2'); ?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Wijzigen</button>
		</div>
	</div>
</form>