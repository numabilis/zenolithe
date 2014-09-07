<div class="formField">
	<label for="google_adsense_account">Compte Google AdSense</label>
	<input type="text" name="google_adsense_account" value="<?php echo $model->getfield('google_adsense_account'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('google_adsense_account')) {
            echo $model->getErrorCode('google_adsense_account');
        }
	?>
	</div>
</div>
<div class="formField">
	<label for="google_adsense_slot">Slot</label>
	<input type="text" name="google_adsense_slot" value="<?php echo $model->getField('google_adsense_slot'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('google_adsense_slot')) {
            echo $model->getErrorCode('google_adsense_slot');
        }
	?>
	</div>
</div>
