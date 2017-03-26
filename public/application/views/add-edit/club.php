<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('clubs');?>">Clubs</a> <span class="divider">/</span></li>
	<li><a href="<?=site_url('clubs/'.$club_id.'/'.url_title(e($name)));?>"><?=e($name);?></a> <span class="divider">/</span></li>
	<li class="active">Bewerken</li>
</ul>

<h1>Club pagina bewerken</h1>
<hr>
<?=form_open_multipart('',array('class' => 'form-horizontal'));?>
	<div class="control-group<?=form_error('name') ? ' error' : '';?>">
		<label class="control-label" for="name">Naam</label>
		<div class="controls">
			<input type="text" id="name" name="name" placeholder="Naam" value="<?=set_value('name',(isset($name) ? $name : '')); ?>">
			<span class="help-inline"><?=form_error('name'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('email') ? ' error' : '';?>">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="email" id="email" name="email" placeholder="Email" value="<?=set_value('email',(isset($email) ? $email : '')); ?>">
			<span class="help-inline"><?=form_error('email'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('website') ? ' error' : '';?>">
		<label class="control-label" for="website">Website</label>
		<div class="controls">
			<input type="text" id="website" name="website" placeholder="Website" value="<?=set_value('website',(isset($website) ? $website : '')); ?>">
			<span class="help-inline"><?=form_error('website'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('description') ? ' error' : '';?>">
		<label class="control-label" for="description">Omschrijving</label>
		<div class="controls">
			<textarea name="description" id="description" placeholder="Omschrijving"><?=set_value('description',(isset($description) ? $description : '')); ?></textarea>
			<span class="help-inline"><?=form_error('description'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('open') ? ' error' : '';?>">
		<div class="controls">
			<label class="checkbox" for="open">
				<input type="checkbox" id="open" name="open" value="1"<?=set_checkbox('open',1,(isset($open) AND $open == 1 ? TRUE : FALSE)); ?>> Open club? Dit houdt in dat leden zich zelf kunnen aanmelden als lid van de club
			</label>
			<span class="help-inline"><?=form_error('open'); ?></span>
		</div>
	</div>
	<div class="control-group<?=form_error('members') ? ' error' : '';?>" id="members-check"<?=(set_checkbox('open',1,(isset($open) AND $open == 1 ? TRUE : FALSE)) ? ' style="display: none;"' : '');?>>
		<label class="control-label" for="members">Leden</label>
		<div class="controls">
			<textarea name="members" id="members" placeholder="Leden"><?=set_value('members',(isset($members) ? $members : '')); ?></textarea>
			<span class="help-inline"><?=form_error('members') ?: 'Noteer hier alle "'.site_name().' gebruikers ID\'s", gescheiden door een komma\'s! LET OP! Géén spaties, een enter of andere karakters! Dus gewoon: 1,2,3'; ?></span>
		</div>
	</div>
	<div class="control-group<?=isset($error) ? ' error' : '';?>">
		<label class="control-label" for="logo">Logo</label>
		<div class="controls">
			<input type="file" id="logo" name="logo">
			<span class="help-inline"><?=isset($error) ? $error : '';?></span>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Bewerken</button>
		</div>
	</div>
</form>