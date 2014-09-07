<div class="formField">
	<label for="ckp_picture_url">URL de l'image</label>
	<input type="text" name="ckp_picture_url" value="<?php echo $model->getField('ckp_picture_url'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('ckp_picture_url')) {
            echo $model->getErrorCode('ckp_picture_url');
        }
	?>
	</div>
</div>

<div class="formField">
	<label for="ckp_link_url">URL du lien</label>
	<input type="text" name="ckp_link_url" value="<?php echo $model->getField('ckp_link_url'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('ckp_link_url')) {
            echo $model->getErrorCode('ckp_link_url');
        }
	?>
	</div>
</div>
