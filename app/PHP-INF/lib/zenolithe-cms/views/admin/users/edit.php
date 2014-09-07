<?php require view_file('admin/top'); ?>

<div id="main">

<a href="list.php"><img src="<?php echo static_url('rsrc/cms/images/users.png'); ?>" /></a>
<div class="formBlock">
<form method="post" action="edit.php" class="admin">
    <input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
<div class="formFieldHalf">
	<label for="usr_last_name">Nom</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_last_name')) {
            echo $model->getErrorCode('usr_last_name');
        }
    ?>
	</div>
	<input type="text" name="usr_last_name" value="<?php echo $model->getField('usr_last_name'); ?>" />
</div>
<div class="formFieldHalf">
	<label for="usr_first_name">Prénom</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_first_name')) {
            echo $model->getErrorCode('usr_first_name');
        }
    ?>
	</div>
	<input type="text" name="usr_first_name" value="<?php echo $model->getField('usr_first_name'); ?>" />
</div>
<div class="formFieldHalf">
	<label for="usr_email">Mail</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_email')) {
            echo $model->getErrorCode('usr_email');
        }
    ?>
	</div>
	<input type="text" name="usr_email" value="<?php echo $model->getField('usr_email'); ?>" />
</div>
<div class="formFieldHalf">
	<label for="usr_login">Login</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_login')) {
            echo $model->getErrorCode('usr_login');
        }
    ?>
	</div>
	<input type="text" name="usr_login" value="<?php echo $model->getField('usr_login'); ?>" />
</div>
<?php if($model->getAttribute('usr_id') == 0) { ?>
<div class="formFieldHalf">
	<label for="usr_password">Mot de passe</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_password')) {
            echo $model->getErrorCode('usr_password');
        }
    ?>
	</div>
	<input type="password" id="password" value="" />
</div>
<input type="hidden" name="usr_password" id="usr_password" value="" />
<?php } ?>
<div class="formFieldHalf">
	<label for="usr_profile">Profil</label>
	<div class="formFieldError">
	<?php
	    if($model->hasError('usr_profile')) {
            echo $model->getErrorCode('usr_profile');
        }
    ?>
	</div>
	<select name="usr_profile">
		<option value="admin_site">Admin de site</option>
	<?php if($model->getField('usr_profile') == 'admin_app') { ?>
		<option value="admin_app" selected="selected">Admin App</option>
	<?php } else { ?>
		<option value="admin_app">Admin App</option>
	<?php } ?>
	</select>
</div>

<div class="formActions">
<?php if($model->getAttribute('usr_id') == 0) { ?>
<center><input class="button" type="submit" value="Valider" onClick="$('#usr_password').val(MD5($('#password').val()));" /></center>
<?php } else { ?>
<center><input class="button" type="submit" value="Enregistrer" /></center>
<?php } ?>
</div>

</form>
</div>

</div>

<?php require view_file('admin/bottom'); ?>
