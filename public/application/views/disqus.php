<?php
define('DISQUS_SECRET_KEY', 'SECRET KEY');
define('DISQUS_PUBLIC_KEY', 'PUBLIC KEY');
 
$data = array(
		"id" => user('user_id'),
		"username" => user('username'),
		"email" => user('email')
	);
 
function dsq_hmacsha1($data, $key) {
	$blocksize=64;
	$hashfunc='sha1';
	if (strlen($key)>$blocksize)
		$key=pack('H*', $hashfunc($key));
	$key=str_pad($key,$blocksize,chr(0x00));
	$ipad=str_repeat(chr(0x36),$blocksize);
	$opad=str_repeat(chr(0x5c),$blocksize);
	$hmac = pack(
				'H*',$hashfunc(
					($key^$opad).pack(
						'H*',$hashfunc(
							($key^$ipad).$data
						)
					)
				)
			);
	return bin2hex($hmac);
}
 
$message = base64_encode(json_encode($data));
$timestamp = time();
$hmac = dsq_hmacsha1($message . ' ' . $timestamp, DISQUS_SECRET_KEY);
?>
<div id="disqus_thread"></div>
<script type="text/javascript">
var disqus_shortname = 'fastrnl';
(function() {
	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
<noscript><div class="alert alert-error">Set Javascript aan om de reacties te bekijken.</div></noscript>
<script type="text/javascript">
var disqus_config = function() {
	this.page.remote_auth_s3 = "<?="$message $hmac $timestamp"; ?>";
	this.page.api_key = "<?=DISQUS_PUBLIC_KEY; ?>";
	this.sso = {
		name: 	"Fastr",
		button: "//fastr.nl/img/disqus-login.jpg",
		icon: 	"//fastr.nl/favicon.ico",
		url: 	"//fastr.nl/login",
		logout: "//fastr.nl/logout",
		width: 	"1000",
		height: "800"
	};
}
</script>
