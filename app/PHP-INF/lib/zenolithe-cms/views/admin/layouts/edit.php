<?php require view_file('admin/top'); ?>

<div id="main">
	Gabarit : <?php echo $this->getString('template_'.$model->getAttribute('template_name').'_name'); ?><br />
	Type : <?php echo $this->getString('template_'.$model->getAttribute('template_name').'_page_'.$model->getAttribute('layout_type')); ?>
	
	<div id="componentChooser" class="popup">
		<div class="content">
			<form method="post" action="edit.php" name="componentChooser">
        <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
				<input type="hidden" name="zoneName" value="" />
				<input type="hidden" name="action" value="add" />
				<label for="componentId">Coposant à ajouter :</label>
				<select name="componentId">
	      <?php
	      	foreach($model->getAttribute('components') as $cpt) {
    	  ?>
		    	<option value="<?php echo $cpt['cpt_id']; ?>"><?php echo $cpt['cpt_name']; ?></option>
	       <?php
	    	 	 }
    	   ?>
		     </select>
	    	</div>
	    </form>
	</div>
	
	<div id="componentRemover" class="popup">
		<div class="content">
			Supprimer ce composant ?
			<form method="post" action="edit.php" name="componentRemover">
        <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
				<input type="hidden" name="zoneName" value="" />
				<input type="hidden" name="componentId" value="" />
				<input type="hidden" name="componentOrder" value="" />
				<input type="hidden" name="action" value="remove" />
		    </form>
	    </div>
	</div>
	
	<div id="componentMover" class="hidden">
		<form method="post" action="edit.php" name="componentMover">
      <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
			<input type="hidden" name="zoneName" value="" />
			<input type="hidden" name="componentId" value="" />
			<input type="hidden" name="componentOrder" value="" />
			<input type="hidden" name="action" value="" />
	    </form>
	</div>
	
	<div id="componentExchanger" class="popup">
		<div class="content">
			<form method="post" action="edit.php" name="componentExchanger">
        <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
				<input type="hidden" name="action" value="exchange" />
				<input type="hidden" name="zoneName" value="" />
				<input type="hidden" name="componentOrder" value="" />
				<input type="hidden" name="componentId" value="" />
        <label for="newComponentId">Coposant de remplacement :</label>
				<select name="newComponentId">
					<?php
						foreach ($model->getAttribute('components') as $cpt) {
							echo '<option value="'.$cpt['cpt_id'].'">'.$cpt['cpt_name'].'</option>';
	    	   	}
    	    ?>
		    </select>
		  </form>
		</div>
	</div>
	
	<form method="post" enctype="multipart/form-data" action="edit.php" id="templateForm">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
		<input type="hidden" name="action" value="styles" />
		<div class="formFieldLarge">
			<label for="layout_name">Nom</label>
			<div class="formFieldError">
			<?php
				if($model->hasError('layout_name')) {
					echo $model->getErrorCode('layout_name');
				}
			?>
		  </div>
		  <input type="text" name="layout_name" value="<?php echo $model->getField('layout_name'); ?>" />
		</div>
		
		<?php if($model->getAttribute('layout_id')) { ?>
			<?php foreach($model->getAttribute('template_zones') as $zone) { ?>
	    	<div class="zone">
	        	<div class="header">
	            	<div class="name"><?php echo $this->getString('template_'.$model->getAttribute('template_name').'_zone_'.$zone); ?></div>
	    			<div class="actions">
	    				<a href="#" onclick="componentAdd('<?php echo $zone; ?>'); return false;"><img border="0" src="<?php echo static_url('rsrc/cms/images/brick_add.png'); ?>"></a>
	    			</div>
	        	</div>
	        	
	        	<?php
	        		$layoutComponents = $model->getField('layout_components');
	        	    if(isset($layoutComponents[$zone])) {
	        	        foreach($layoutComponents[$zone] as $cpt) {
	        	        
	        	?>
	        	<div class="component">
	            	<div class="name"><?php echo $cpt['cpt_name']; ?></div>
	            	<div class="style">
	            	    <select name="classes[<?php echo $cpt['ctx_component_id'].','.$zone.','.$cpt['ctx_order']; ?>]">
	                	<?php
	                	    foreach($model->getAttribute('template_classes') as $class) {
	                	        if($cpt['ctx_class'] == $class) {
	                	            echo '<option selected="selected" value="'.$class.'">'.$this->getString('template_'.$model->getAttribute('template_name').'_class_'.$class).'</option>';
	                	        } else {
	                	            echo '<option value="'.$class.'">'.$this->getString('template_'.$model->getAttribute('template_name').'_class_'.$class).'</option>';
	                	        }
	                	    }
	                	?>
	            		</select>
	            	</div>
	    			<div class="actions">
	    				<a href="#" onclick="componentMove('<?php echo $zone; ?>', <?php echo $cpt['cpt_id']; ?>, <?php echo $cpt['ctx_order']; ?>, 'down'); return false;"><img src="<?php echo static_url('rsrc/cms/images/arrow-down.png'); ?>"></a>
	    				<a href="#" onclick="componentMove('<?php echo $zone; ?>', <?php echo $cpt['cpt_id']; ?>, <?php echo $cpt['ctx_order']; ?>, 'up'); return false;"><img src="<?php echo static_url('rsrc/cms/images/arrow-up.png'); ?>"></a>
	    				<a href="#" onclick="componentRemove('<?php echo $zone; ?>', <?php echo $cpt['cpt_id']; ?>, <?php echo $cpt['ctx_order']; ?>); return false;"><img src="<?php echo static_url('rsrc/cms/images/brick_delete.png'); ?>"></a>
	    				<a href="#" onclick="componentExchange('<?php echo $zone; ?>', <?php echo $cpt['cpt_id']; ?>, <?php echo $cpt['ctx_order']; ?>); return false;" title="Echanger avec un autre composant"><img src="<?php echo static_url('rsrc/cms/images/brick_go.png'); ?>"></a>
	    			</div>
	        	</div>
	        	<?php
	        	        }
	    	        }
	        	?>
	        </div>
			<?php } ?>
	    <?php } ?>
	    
    	<div class="formActions">
    		<input class="button" type="submit" value="Enregistrer" />
    	</div>
	</form>
</div>

<?php require view_file('admin/bottom'); ?>
