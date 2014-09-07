<input type="hidden" name="mcp_count" value="<?php echo $model->getField('mcp_count'); ?>" />
<?php for($i=0; $i<$model->getField('mcp_count'); $i++) {?>
<input type="hidden" name="mcp_id_<?php echo $i; ?>" value="<?php echo $model->getField('mcp_id_'.$i); ?>" />
<div class="formField">
	<label for="mcp_picture_url_<?php echo $i; ?>">URL de l'image <?php echo $i; ?></label>
	<input type="text" name="mcp_picture_url_<?php echo $i; ?>" value="<?php echo $model->getField('mcp_picture_url_'.$i); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('mcp_picture_url_'.$i)) {
            echo $model->getErrorCode('mcp_picture_url_'.$i);
        }
	?>
	</div>
</div>

<div class="formField">
	<label for="mcp_link_url_<?php echo $i; ?>">URL du lien <?php echo $i; ?></label>
	<input type="text" name="mcp_link_url_<?php echo $i; ?>" value="<?php echo $model->getField('mcp_link_url_'.$i); ?>" />
	<div class="formFieldError">
	<?php
        if($model->hasError('mcp_link_url_'.$i)) {
            echo $model->getErrorCode('mcp_link_url_'.$i);
        }
	?>
	</div>
</div>
<?php } ?>
