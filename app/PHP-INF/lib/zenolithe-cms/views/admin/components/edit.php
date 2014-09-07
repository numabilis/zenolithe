<?php require view_file('admin/top'); ?>

<div id="main">
    <?php
        $config = false;
        require view_file('admin/components/menu');
    ?>
    
	<form method="post" enctype="multipart/form-data" action="edit.php">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    	<div class="formBlock">
    		<div class="formField">
	    		Nom du composant : <strong><?php echo $model->getField('cpt_name'); ?></strong>
    		</div>
    	</div>
		<?php
    		if($model->getAttribute('component-localization-view')) {
    	        echo '<div class="formBlock">';
    		    require view_file($model->getAttribute('component-localization-view'));
    		    echo '</div>';
		    }
		?>
    	<div class="formActions">
    		<input class="button" type="submit" value="Enregistrer" />
    	</div>
	</form>
</div>

<?php require view_file('admin/bottom'); ?>
