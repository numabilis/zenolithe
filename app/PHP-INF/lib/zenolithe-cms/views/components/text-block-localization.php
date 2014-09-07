<div class="formField">
	<label for="hbk_title">Titre</label>
	<input type="text" name="hbk_title" value="<?php echo $model->getField('hbk_title'); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('hbk_title')) {
            echo $model->getErrorCode('hbk_title');
        }
	?>
	</div>
</div>

<div class="formField">
	<label for="hbk_content">Contenu</label><br />
	<textarea name="hbk_content"><?php echo $model->getField('hbk_content'); ?></textarea>
</div>

