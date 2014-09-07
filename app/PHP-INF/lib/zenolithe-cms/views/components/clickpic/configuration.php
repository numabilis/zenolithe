<div class="formField">
	<label for="click_pic_localizable">Composant localisable</label>
	<?php if($model->getAttribute('click_pic_localizable')) { ?>
	<input type="checkbox" name="click_pic_localizable" value="t" checked="checked" />
	<?php } else { ?>
	<input type="checkbox" name="click_pic_localizable" value="t" />
	<?php } ?>
	<div class="formFieldError">
	<?php
        if($model->hasError('click_pic_localizable')) {
            echo $model->getErrorCode('click_pic_localizable');
        }
	?>
	</div>
</div>

<div class="formField">
	<label for="click_pic_picture_url">URL de l'image</label>
	<input type="text" name="click_pic_picture_url" value="<?php echo $model->getField('click_pic_picture_url'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('click_pic_picture_url')) {
            echo $model->getErrorCode('click_pic_picture_url');
        }
	?>
	</div>
</div>

<div class="formField">
	<label for="click_pic_link_url">URL du lien</label>
	<input type="text" name="click_pic_link_url" value="<?php echo $model->getField('click_pic_link_url'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('click_pic_link_url')) {
            echo $model->getErrorCode('click_pic_link_url');
        }
	?>
	</div>
</div>
