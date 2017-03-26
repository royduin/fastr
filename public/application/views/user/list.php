<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Gebruikers</li>
</ul>
<h1><?=site_name();?> gebruikers</h1>
<hr>
<div class="row-fluid">
	<ul class="thumbnails">
		<? foreach($users as $user): ?>
			<? $url = site_url('user/'.$user->user_id.'/'.url_title(e($user->username)));?>
			<li class="span2">
				<div class="thumbnail">
					<a href="<?=$url;?>"><img src="//www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)));?>?s=160&d=<?=urlencode(site_url('img/geen-foto.png'));?>" alt="Avatar van <?=e($user->username);?>"></a>
					<a href="<?=$url;?>"><?=max_length(e($user->username),10);?></a>
				</div>
			</li>
		<? endforeach; ?>
	</ul>
</div>
