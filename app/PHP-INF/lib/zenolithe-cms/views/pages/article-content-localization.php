<div class="formField">
	<label for="article_content">Contenu</label>
	<div class="formFieldError">
	<?php
        if($model->hasError('article_content')) {
            echo $model->getErrorCode('article_content');
        }
	?>
	</div><br />
	<textarea class="wysiwyg" name="article_content"><?php echo $model->getField('article_content'); ?></textarea>
</div>
