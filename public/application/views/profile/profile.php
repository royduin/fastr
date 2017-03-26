<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('dashboard');?>">Dashboard</a> <span class="divider">/</span></li>
	<li class="active">Profiel van <?=user('username');?></li>
</ul>
<h1>Profiel van <?=user('username');?></h1>
<hr>
<div class="alert">Velden met een * zijn verplicht</div>
<?=form_open('',array('class' => 'form-horizontal'));?>
	<div class="control-group">
		<label class="control-label">Profiel afbeelding</label>
		<div class="controls">
			<img src="//www.gravatar.com/avatar/<?=md5(strtolower(trim($email)));?>?s=210&d=<?=urlencode(site_url('img/geen-foto.png'));?>" alt="Avatar van <?=$username;?>" class="img-polaroid">
			<span class="help-inline alert">Voor profiel afbeeldingen maakt <?=site_name();?> gebruik van <a href="http://gravatar.com" target="_blank">Gravatar</a>.<br>Gravatar maakt het mogelijk om overal dezelfde avatar cq profiel afbeelding te hebben.<br>Mocht je nog geen Gravatar hebben, maak dan eenvoudig een account op: <a href="http://gravatar.com/site/signup" target="_blank">http://gravatar.com/site/signup</a></span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="username">Gebruikersnaam</label>
		<div class="controls">
			<input type="text" id="username" name="username" placeholder="Gebruikersnaam" value="<?=set_value('username',(isset($username) ? $username : '')); ?>" disabled="disabled">
			<span class="help-inline">De gebruikersnaam kan niet gewijzigd worden</span>
		</div>
	</div>
	<div class="control-group<?=form_error('email') ? ' error' : '';?>">
		<label class="control-label" for="email">Email adres *</label>
		<div class="controls">
			<input type="email" id="email" name="email" placeholder="Email adres" value="<?=set_value('email',(isset($email) ? $email : '')); ?>">
			<span class="help-inline"><?=form_error('email'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('city') ? ' error' : '';?>">
		<label class="control-label" for="city">Woonplaats</label>
		<div class="controls">
			<input type="text" id="city" name="city" placeholder="Woonplaats" value="<?=set_value('city',(isset($city) ? $city : '')); ?>">
			<span class="help-inline"><?=form_error('city'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('website') ? ' error' : '';?>">
		<label class="control-label" for="website">Website</label>
		<div class="controls">
			<input type="text" id="website" name="website" placeholder="Website" value="<?=set_value('website',(isset($website) ? $website : '')); ?>">
			<span class="help-inline"><?=form_error('website'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('birth') ? ' error' : '';?>">
		<label class="control-label" for="birth">Geboorte datum</label>
		<div class="controls">
			<input type="date" id="birth" name="birth" placeholder="Geboorte datum" value="<?=set_value('birth',(isset($birth) ? $birth : '')); ?>">
			<span class="help-inline"><?=form_error('birth'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('description') ? ' error' : '';?>">
		<label class="control-label" for="description">Wie ben je?</label>
		<div class="controls">
			<textarea id="description" name="description" placeholder="Korte omschrijving over jezelf..."><?=set_value('description',(isset($description) ? $description : '')); ?></textarea>
			<span class="help-inline"><?=form_error('description'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('visible') ? ' error' : '';?>">
		<label class="control-label" for="visible">Je profiel zichtbaar voor *</label>
		<div class="controls">
			<select id="visible" name="visible">
				<option value="0"<?=set_select('visible',0,($visible == 0 ? TRUE : FALSE));?>>Iedereen</option>
				<option value="1"<?=set_select('visible',1,($visible == 1 ? TRUE : FALSE));?>>Ingelogde gebruikers</option>
				<!--<option value="2"<?=set_select('visible',2,($visible == 2 ? TRUE : FALSE));?>>Leden van clubs waar je bij aangesloten bent</option>-->
			</select>
			<span class="help-inline"><?=form_error('visible'); ?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<a href="<?=site_url('profile/password');?>">Wachtwoord wijzigen</a>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Bewerken</button>
		</div>
	</div>
</form>
