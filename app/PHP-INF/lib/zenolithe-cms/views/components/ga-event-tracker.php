<?php
	use org\zenolithe\kernel\bootstrap\Configuration;
	
	if(!Configuration::$debug) {
		if(isset($model->get('gaq_category')) && $model->get('gaq_category') && $model->get('gaq_action')) {
			$cmd = "['_trackEvent', '".$model->get('gaq_category')."', '".$model->get('gaq_action')."'";
			if(isset($model->get('gaq_label')) && $model->get('gaq_label')) {
				$cmd .= ", '".$model->get('gaq_label')."'";
				if(isset($model->get('gaq_value')) && $model->get('gaq_value')) {
					$cmd .= ", '".$model->get('gaq_value')."'";
				}
			}
			$cmd .= "]";
?>
<script type="text/javascript">
	_gaq.push(<?php echo $cmd; ?>);
</script>
<?php } ?>
<?php } else { ?>
<!-- Google Analytics Event Tracking -->
<?php } ?>
