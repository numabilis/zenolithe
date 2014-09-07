<div class="formField">
	<label for="google_analytics_account">Compte Google Analytics</label>
	<input type="text" name="google_analytics_account" value="<?php echo $model->getField('google_analytics_account'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('google_analytics_account')) {
            echo $model->getErrorCode('google_analytics_account');
        }
	?>
	</div>
</div>
