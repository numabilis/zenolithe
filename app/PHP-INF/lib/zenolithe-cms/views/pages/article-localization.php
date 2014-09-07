<div class="formField">
	<label for="article_title">Titre</label>
	<div class="formFieldError">
	<?php
    if($model->hasError('article_title')) {
      echo $model->getErrorCode('article_title');
    }
	?>
	</div><br />
	<input type="text" name="article_title" value="<?php echo $model->getField('article_title'); ?>" />
</div>
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
