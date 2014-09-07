<div class="formField">
	<label for="parameters">Paramètres</label>
	<input type="text" name="parameters" value="<?php echo $model->getField('parameters'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('parameters')) {
            echo $model->getErrorCode('parameters');
        }
	?>
	</div>
</div>
