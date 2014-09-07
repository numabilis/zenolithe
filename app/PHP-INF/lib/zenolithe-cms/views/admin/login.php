<?php
$menuItem = 'login';
require view_file('admin/top');
?>

<div id="main">

    <form method="post" action="login.php" class="admin">
    	<div class="formBlock">
    		<div class="formField">
	    		<label for="login-form-login">Login :</label>
    			<input type="text" name="login-form-login" value="<?php echo $model->getField('login-form-login'); ?>" />
    			<div class="formFieldError">
    	        <?php
    	            if($model->hasError('login-form-login')) {
                        echo $model->getErrorCode('login-form-login');
                    }
                ?>
    			</div>
    		</div>
    		
            <div class="formField">
            	<label for="login-form-password">Mot de passe :</label>
            	<input type="password" id="password" value="" />
            	<div class="formFieldError">
            	<?php
            	    if($model->hasError('login-form-password')) {
                        echo $model->getErrorCode('login-form-password');
                    }
                ?>
            	</div>
            </div>
    	</div>
	    <input type="hidden" name="login-form-password" id="login-form-password" value="" />
    	
    	<div class="formActions">
    		<input type="submit" class="button" value="Valider" onClick="$('#login-form-password').val(MD5($('#password').val()));" />
    	</div>
    </form>

</div>

<?php require view_file('admin/bottom'); ?>
