<div class="formField">
	<label for="gawLabel">Label</label>
	<input type="text" name="gawLabel" value="<?php echo $model->getField('gawLabel'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('gawLabel')) {
            echo $model->getErrorCode('gawLabel');
        }
	?>
	</div>
</div>
