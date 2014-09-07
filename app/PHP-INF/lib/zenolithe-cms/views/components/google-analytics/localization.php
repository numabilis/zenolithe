<div class="formField">
	<label for="gaq_category">Catégorie</label>
	<input type="text" name="gaq_category" value="<?php echo $model->getField('gaq_category'); ?>" />
	<div class="formFieldError">
    <?php
        if($model->hasError('gaq_category')) {
            echo $model->getErrorCode('gaq_category');
        }
    ?>
	</div>
</div>

<div class="formField">
	<label for="gaq_action">Action</label>
	<input type="text" name="gaq_action" value="<?php echo $model->getField('gaq_action'); ?>" />
	<div class="formFieldError">
    <?php
        if($model->hasError('gaq_action')) {
            echo $model->getErrorCode('gaq_action');
        }
    ?>
	</div>
</div>

<div class="formField">
	<label for="gaq_label">Libellé</label>
	<input type="text" name="gaq_label" value="<?php echo $model->getField('gaq_label'); ?>" />
	<div class="formFieldError">
    <?php
        if($model->hasError('gaq_label')) {
            echo $model->getErrorCode('gaq_label');
        }
    ?>
	</div>
</div>

<div class="formField">
	<label for="gaq_value">Valeur</label>
	<input type="text" name="gaq_value" value="<?php echo $model->getField('gaq_value'); ?>" />
	<div class="formFieldError">
    <?php
        if($model->hasError('gaq_value')) {
            echo $model->getErrorCode('gaq_value');
        }
    ?>
	</div>
</div>
