<ul class="breadcrumb">
	<li><a href="<?=site_url();?>">Home</a> <span class="divider">/</span></li>
	<li class="active">Zoeken <?=$this->input->get('q') ? ' naar '.e($this->input->get('q')) : '';?></li>
</ul>
<h1>Zoeken<?=$this->input->get('q') ? ' naar '.e($this->input->get('q')) : '';?></h1>
<hr>
<div class="alert">De zoekfunctie wordt nog aan gewerkt</div>