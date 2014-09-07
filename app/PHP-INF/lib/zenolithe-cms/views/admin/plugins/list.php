<?php require view_file('admin/top'); ?>

<div id="main">
    <table class="list">
    	<tr>
    		<th>Nom</th>
    		<th>Type</th>
    		<th>Substitut</th>
    		<th>Actions</th>
    	</tr>
    <?php foreach ($model->get('components-list') as $component) { ?>
    	<tr>
    		<td><?php echo $component['cpt_name']; ?></td>
    		<td><?php echo $this->getString('component_'.$component['cpt_type'].'_name'); ?></td>
    		<td>
			<?php
			    if($component['cpt_substitute_id'] == 0) {
			        echo 'Aucun';
			    } else if($component['cpt_substitute_id'] == -1) {
			        echo 'Lui-même';
			    } else {
			        foreach($model->get('components-list') as $substitute) {
			            if($substitute['cpt_id'] == $component['cpt_substitute_id'])  {
			                echo $substitute['cpt_name'];
			                break;
			            }
			        }
			    }
			?>
    		</td>
    		<td class="actions">
    			<a href="edit.php?id=<?php echo $component['cpt_id']; ?>"><img src="<?php echo static_url('rsrc/cms/images/brick_edit.png'); ?>" /></a>
    			<!-- a href="copy.php?id=<?php echo $component['cpt_id']; ?>" title="Copier"><img src="<?php echo static_url('rsrc/cms/images/brick_copy.png'); ?>" /></a>
    			&nbsp;
    			<a href="delete.php?id=<?php echo $component['cpt_id']; ?>" title="Supprimer"><img src="<?php echo static_url('rsrc/cms/images/brick_delete.png'); ?>" /></a -->
    		</td>
    	</tr>
    <?php } ?>
    </table>
    
    <?php
    	$types = array();
    	foreach ($model->get('components-types') as $cptType) {
    		$types[$cptType['type']] = $this->getString('component_'.$cptType['type'].'_name');
    	}
    	asort($types);
    ?>
    <div class="listActions">
    	<form method="get" action="configure.php">
        	<label for="components-types">Nouveau </label>
        	<select id="components-types" name="type">
        	<?php foreach ($types as $type => $name) { ?>
        		<option value="<?php echo $type; ?>"><?php echo $name; ?></option>
        	<?php } ?>
        	</select>
        	<input class="button" type="submit" value="OK" />
    	</form>
	</div>
</div>

<?php require view_file('admin/bottom'); ?>
