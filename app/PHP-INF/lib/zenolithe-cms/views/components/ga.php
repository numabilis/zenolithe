<?php
	use org\zenolithe\kernel\bootstrap\Configuration;
	if(!Configuration::$debug) {
?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $model->get('google-analytics-account'); ?>']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<?php } else { ?>
<!-- Google Analytics code for ID <?php echo $model->get('google-analytics-account'); ?> -->
<?php } ?>
