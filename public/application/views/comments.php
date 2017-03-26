<? $comments = $this->db->join('users','comments.user_id = users.user_id')->get_where('comments',['what' => $what,'what_id' => $id])->result(); ?>
<? if(empty($comments)): ?>
	<div class="alert alert-error">Er zijn nog geen reacties</div>
<? else: ?>
	<ul class="media-list well">
		<? foreach($comments as $comment): ?>
			<li class="media bookmark" id="reactie-<?=$comment->comment_id;?>">
				<a class="pull-left tip" href="<?=site_url('user/'.$comment->user_id.'/'.url_title(e($comment->username)));?>" title="Ga naar het profiel van <?=e($comment->username);?>">
					<img src="//www.gravatar.com/avatar/<?=md5(strtolower(trim($comment->email)));?>?s=64&d=<?=urlencode(site_url('img/geen-foto.png'));?>" alt="Avatar van <?=$comment->username;?>" class="img-polaroid pull-right" width="64">
				</a>
				<div class="media-body">
					<small class="pull-right"><?=($comment->user_id == user('user_id') ? '<a href="#" class="edit-comment" data-id="'.$comment->comment_id.'"><i class="icon-edit"></i> Bericht bewerken</a> ' : '');?><?=date('H:i d-m-Y',strtotime($comment->time));?> geplaatst (<a href="#reactie-<?=$comment->comment_id;?>" class="tip" title="Linken naar een reactie">#<?=$comment->comment_id;?></a>)</small>
					<h4 class="media-heading"><a href="<?=site_url('user/'.$comment->user_id.'/'.url_title(e($comment->username)));?>" class="tip" title="Ga naar het profiel van <?=e($comment->username);?>"><?=e($comment->username);?></a></h4>
					<p><?=nl2br(e($comment->comment));?></p>
				</div>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>

<h2>Reageer</h2>
<? if(!logged_in()): ?>
	<div class="alert alert-error">Om te reageren dien je ingelogd te zijn</div>
<? else: ?>
	<?=form_open('add-edit/comment/'.$what.'/'.$id,['class' => 'well'],['source' => current_url()]);?>
		<textarea name="comment" required></textarea>
		<button type="submit" class="btn btn-primary pull-right"><i class="icon-ok icon-white"></i> Reageren</button>
		<div class="clearfix"></div>
	</form>
<? endif; ?>
