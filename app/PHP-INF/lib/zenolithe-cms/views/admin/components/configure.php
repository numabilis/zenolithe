<?php require view_file('admin/top'); ?>

<div id="main">
	<div class="menu">
    <?php
        $config = true;
        require view_file('admin/components/menu');
    ?>
	</div>
	<form method="post" enctype="multipart/form-data" action="configure.php">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    	<div class="formBlock">
    		<div class="formFieldLarge">
    			<label for="cpt_name">Nom</label>
    			<input type="text" name="cpt_name" value="<?php echo $model->getField('cpt_name'); ?>" />
    			<div class="formFieldError">
    			<?php
            	    if($model->hasError('cpt_name')) {
                        echo $model->getErrorCode('cpt_name');
                    }
        	    ?>
        		</div>
    		</div>
    		<div class="formFieldSmall">
    			<label for="cpt_substitute_id">Substitut</label>
    			<select id="cpmSubstitution" name="cpt_substitute_id" class="cpmSubstitution">
    				<option value="0">Aucun</option>
    			<?php if($model->getField('cpt_substitute_id') == -1) { ?>
    				<option value="-1" selected="selected">Lui-même (dans une autre langue)</option>
    			<?php } else { ?>
    				<option value="-1">Lui-même (dans une autre langue)</option>
    		    <?php } ?>
   				<?php
				    foreach ($model->getAttribute('components-list') as $component) {
					    if($component['cpt_id'] == $model->getField('cpt_substitute_id')) {
				?>
					<option value="<?php echo $component['cpt_id']; ?>" selected="selected"><?php echo $component['cpt_name']; ?></option>
				<?php
                        } else {
				?>
					<option value="<?php echo $component['cpt_id']; ?>"><?php echo $component['cpt_name']; ?></option>
				<?php
					    }
				    }
				?>
    			</select>
			</div>
    	</div>
		<?php
    		if($model->getAttribute('component-configuration-view')) {
    	        echo '<div class="formBlock">';
    		    require view_file($model->getAttribute('component-configuration-view'));
    		    echo '</div>';
		    }
		?>
    	<div class="formActions">
    		<input class="button" type="submit" value="Enregistrer" />
    	</div>
	</form>
</div>

<?php require view_file('admin/bottom'); ?>
