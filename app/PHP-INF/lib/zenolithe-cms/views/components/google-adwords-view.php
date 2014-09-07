<?php
	use org\zenolithe\kernel\bootstrap\Configuration;
	if($model->get('show')) {
		if(Configuration::$debug) {
			echo '<!--';
		}
?>
<?php // TODO: put parameters in component parameters ?>
<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 1011025188;
	var google_conversion_language = "en";
	var google_conversion_format = "2";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "<?php echo $model->get('label'); ?>";
	var google_conversion_value = 0;
	var google_remarketing_only = false;
	/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
	<div style="display:inline;">
	  <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1011025188/?value=0&amp;label=<?php echo $model->get('label'); ?>&amp;guid=ON&amp;script=0"/>
	</div>
</noscript>
<?php
	if(Configuration::$debug) {
		echo '-->';
	}
?>
<?php } ?>
