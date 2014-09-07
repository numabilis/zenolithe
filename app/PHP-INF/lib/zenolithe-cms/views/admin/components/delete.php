<?php require view_file('admin/top'); ?>

<div id="main">
	<form method="post" enctype="multipart/form-data" action="delete.php">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    	<div class="formBlock">
    		<div class="formField">
	    		Nom du composant : <strong><?php echo $model->getField('cpt_name'); ?></strong>
    		</div>
    	</div>
    	<div class="formBlock"><div class="formField">Êtes vous sûr de vouloir supprimer ce composant ?</div></div>
    	<div class="formActions">
    		<input class="button" type="submit" value="Supprimer" />
    		<a href="list.php" class="button">Annuler</a>
    	</div>
	</form>
</div>

<?php require view_file('admin/bottom'); ?>
