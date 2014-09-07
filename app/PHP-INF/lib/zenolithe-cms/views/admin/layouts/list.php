<?php require view_file('admin/top'); ?>

<div id="main">
    <table class="list">
    	<tr>
    		<th>Nom</th>
    		<th>Actions</th>
    	</tr>
    <?php foreach ($model->get('layouts') as $layout) { ?>
    	<tr>
    		<td><?php echo $layout['lay_name']; ?></td>
    		<td class="actions">
    			<a href="edit.php?id=<?php echo $layout['lay_id']; ?>" title="&Eacute;diter"><img src="<?php echo static_url('rsrc/cms/images/layout_edit.png'); ?>" /></a>
    		</td>
    	</tr>
    <?php } ?>
    </table>
    
    <?php
    	$types = array();
    	$template = $model->get('template');
    	foreach ($template['zones'] as $pageType => $pageZones) {
    		$types[$pageType] = $this->getString('template_'.$template['name'].'_page_'.$pageType);
    	}
    	asort($types);
    ?>
    <div class="listActions">
    	<form method="get" action="edit.php">
        	<label for="pages-types">Nouveau </label>
        	<select id="pages-types" name="type">
        	<?php foreach ($types as $type => $name) { ?>
        		<option value="<?php echo $type; ?>"><?php echo $name; ?></option>
        	<?php } ?>
        	</select>
        	<input class="button" type="submit" value="OK" />
    	</form>
	</div>

</div>

<?php require view_file('admin/bottom'); ?>
