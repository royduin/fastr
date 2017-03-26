<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title><?=isset($page_title) ? $page_title : site_name().' - '.site_descr();?></title>
		<meta name="description" content="<?=isset($page_descr) ? $page_descr : site_descr();?>">
		<meta name="viewport" content="width=800">
		<link rel="stylesheet" href="<?=site_url('css/bootstrap.min.'.config_item('website_version').'.css');?>">
		<link rel="stylesheet" href="<?=site_url('css/fancybox/jquery.fancybox.css');?>">
		<link rel="stylesheet" href="<?=site_url('css/fancybox/jquery.fancybox-buttons.css');?>">
		<link rel="stylesheet" href="<?=site_url('css/nivo-slider.css');?>">
		<link rel="stylesheet" href="<?=site_url('css/main.'.config_item('website_version').'.css');?>">
		<script src="<?=site_url('js/vendor/modernizr-2.6.2.min.js');?>"></script>
	</head>
	<body<?=($page == 'home' ? ' id="home"' : '');?>>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="<?=site_url();?>"><?=site_name();?></a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li<?=(!$this->uri->segment(1) ? ' class="active"' : '');?>><a href="<?=site_url();?>">Home</a></li>
							<li<?=($this->uri->segment(1) == 'user' ? ' class="active"' : '');?>><a href="<?=site_url('user');?>">Gebruikers</a></li>
							<li<?=($this->uri->segment(1) == 'cars' ? ' class="active"' : '');?>><a href="<?=site_url('cars');?>">Auto's</a></li>
							<li<?=($this->uri->segment(1) == 'events' ? ' class="active"' : '');?>><a href="<?=site_url('events');?>">Evenementen</a></li>
							<li<?=($this->uri->segment(1) == 'clubs' ? ' class="active"' : '');?>><a href="<?=site_url('clubs');?>">Clubs</a></li>
							<li<?=($this->uri->segment(1) == 'verzekering' ? ' class="active"' : '');?>><a href="<?=site_url('verzekering');?>">Verzekering</a></li>
							<li<?=($this->uri->segment(1) == 'contact' ? ' class="active"' : '');?>><a href="<?=site_url('contact');?>">Contact</a></li>
						</ul>
						<?=form_open('search',['class' => 'navbar-search','method' => 'get']);?>
							<input type="text" name="q" class="search-query span1" placeholder="Zoeken..."<?=($this->input->get('q') ? ' value="'.e($this->input->get('q')).'"' : '');?>>
						</form>
						<? if($this->session->userdata('username')): ?>
						<ul class="nav pull-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=e($this->session->userdata('username'));?> <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?=site_url('dashboard');?>">Dashboard</a></li>
									<li><a href="<?=site_url('profile');?>">Profiel</a></li>
									<li class="divider"></li>
									<li><a href="<?=site_url('logout');?>">Uitloggen</a></li>
								</ul>
							</li>
						</ul>
						<? else: ?>
							<?=form_open('login',array('class' => 'navbar-form pull-right visible-big'));?>
								<input class="span2" name="username" type="text" placeholder="Gebruikersnaam">
								<input class="span2" name="password" type="password" placeholder="Wachtwoord">
								<button type="submit" class="btn" title="Inloggen"><i class="icon-chevron-right"></i></button>
							</form>
							<ul class="nav pull-right visible-smaller">
								<li><a href="<?=site_url('login');?>">Inloggen</a></li>
							</ul>
						<? endif; ?>
					</div>
				</div>
			</div>
		</div>
			
<? if($page == 'home'): ?>

<div id="slider-top">
	<h1><?=site_name();?></h1>
	<p><?=site_descr();?></p>
</div>

<div id="slider" class="nivoSlider">
	<img src="<?=site_url('img/slides/slide1.jpg');?>" alt="">
	<img src="<?=site_url('img/slides/slide2.jpg');?>" alt="">
	<img src="<?=site_url('img/slides/slide3.jpg');?>" alt="">
</div>

<? endif; ?>

		<div class="container">

		<!--[if lt IE 7]>
			<div class="alert alert-error">Je gebruik een verouderde browser! Gebruik een <a href="http://browsehappy.com/">nieuwe browser</a> of installeer <a href="http://www.google.com/chromeframe/?redirect=true">Google Chrome Frame</a> om de volledige functionaliteiten van de website te gebruiken.</div>
		<![endif]-->

		<?=$this->session->flashdata('message') ? '<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#">&times;</a>'.$this->session->flashdata('message').'</div>' : '';?>

<p class="text-center">Deze website overnemen? Neem contact op met: <a href="mailto:info@fastr.nl">info@fastr.nl</a></p>
