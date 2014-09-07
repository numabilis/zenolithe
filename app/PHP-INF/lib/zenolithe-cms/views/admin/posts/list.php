<?php require view_file('admin/top'); ?>

<div id="main">
	<?php
		$categories = array();
   	foreach ($model->get('categories') as $category) {
   		$categories[$category['cat_id']] = $category['cat_name'];
   	}
   	asort($categories);
	?>
  <div class="listActions">
   	<form method="get" action="list.php">
     	<label for="category">Catégorie : </label>
    	<select id="category" name="category">
      	<?php
      		foreach ($categories as $id => $name) {
						if($model->get('category') == $id) {
							echo '<option value="'.$id.'" selected="selected">'.$name.'</option>';
						} else {
							echo '<option value="'.$id.'">'.$name.'</option>';
						}
					}
				?>
    	</select>
    	<input class="button" type="submit" value="OK" />
  	</form>
	</div>
	
	<div class="listActions">
  	<form method="get" action="edit.php">
     	<input type="hidden" name="" value="<?php echo $model->get('category'); ?>" />
  	 	<input class="button" type="submit" value="Nouveau" />
  	</form>
	</div>
	
</div>

<?php require view_file('admin/bottom'); ?>
