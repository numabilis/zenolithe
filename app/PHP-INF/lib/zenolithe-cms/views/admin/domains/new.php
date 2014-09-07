<?php
require view_file('admin/top');
?>

<div id="main">
	<form method="post" enctype="multipart/form-data" action="new.php">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    	<div class="formBlock">
    		<div class="formFieldSmall">
    			<label for="dom_mnem">Mnem (trigramme)</label>
		    	<div class="formFieldError">
    			<?php
    				if($model->hasError('dom_mnem')) {
							echo $model->getErrorCode('dom_mnem');
            }
        	?>
        	</div>
		    	<input type="text" name="dom_mnem" value="<?php echo $model->getField('dom_mnem'); ?>" />
    		</div>
    		
    		<div class="formField">
    			<label for="dom_base">URL (adresse du site)</label>
		    	<div class="formFieldError">
    			<?php
    				if($model->hasError('dom_base')) {
            	echo $model->getErrorCode('dom_base');
            }
        	?>
        	</div>
		    	<input type="text" name="dom_base" value="<?php echo $model->getField('dom_base'); ?>" />
    		</div>
    		
    		<div class="formField">
    			<label for="dom_languages">Langues supportées (codes séparés par des virgules)</label>
		    	<div class="formFieldError">
    			<?php
    				if($model->hasError('dom_languages')) {
							echo $model->getErrorCode('dom_languages');
						}
        	?>
        	</div>
		    	<input type="text" name="dom_languages" value="<?php echo $model->getField('dom_languages'); ?>" />
    		</div>
    	</div>
    	
    	<div class="formActions">
    		<input class="button" type="submit" value="Enregistrer" />
    	</div>
	</form>
</div>

<?php require view_file('admin/bottom'); ?>
