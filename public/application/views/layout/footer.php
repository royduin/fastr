			<hr>

			<footer>
				<p>&copy; <?=date('Y');?> <?=config_item('website_name');?> - Ontwikkeld door <a href="https://royduineveld.nl" target="_blank">Roy Duineveld</a></p>
			</footer>

		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?=site_url('js/vendor/jquery-1.9.1.min.js');?>"><\/script>')</script>
		<script src="<?=site_url('js/vendor/bootstrap.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.autosize-min.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.mousewheel-3.0.6.pack.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.fancybox.pack.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.fancybox-buttons.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.nivo.slider.pack.js');?>"></script>
		<script src="<?=site_url('js/vendor/jquery.fittext.js');?>"></script>
		<script src="<?=site_url('js/vendor/purl.js');?>"></script>
		<script src="<?=site_url('js/plugins.'.config_item('website_version').'.js');?>"></script>
		<script src="<?=site_url('js/main.'.config_item('website_version').'.js');?>"></script>
		<?=(isset($js) ? '<script src="'.site_url('js/'.$js.'.'.config_item('website_version').'.js').'"></script>' : '');?>
		<script>
			var _gaq=[['_setAccount','UA-41042435-1'],['_trackPageview']];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
			g.src='//www.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<? if(!logged_in() AND !user('modal')): ?>
			<? $this->session->set_userdata('modal', '1'); ?>
			<script type="text/javascript">
				$(window).load(function(){
					//$('#welcomeModal').modal('show');
				});
			</script>
		<? endif; ?>
	</body>
</html>
