<?php require view_file('admin/top'); ?>

<div id="main">
	<?php
        $configure = true;
	    require view_file('admin/pages/menu');
	?>
	
	<form method="post" enctype="multipart/form-data" action="configure.php">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    	<div class="formBlock">
			<div class="formFieldSmall">
				<label for="page_layout_id">Mise en page</label>
				<select name="page_layout_id">
				<?php
					foreach($model->getAttribute('layouts') as $layout) {
						if($model->getField('page_layout_id') == $layout['lay_id']) {
							echo '<option value="'.$layout['lay_id'].'" selected="selected">'.$layout['lay_name'].'</option>';
						} else {
							echo '<option value="'.$layout['lay_id'].'">'.$layout['lay_name'].'</option>';
						}
					}
				?>
				</select>
			</div>
		</div>
	
		<?php
			if($model->getAttribute('page_configuration_view')) {
				echo '<div class="formBlock">';
				require view_file($model->getAttribute('page_configuration_view'));
				echo '</div>';
			}
		?>
		
    	<div class="formActions">
    		<input class="button" type="submit" value="Enregistrer" />
    	</div>
    </form>
	
</div>


<?php require view_file('admin/bottom'); ?>
