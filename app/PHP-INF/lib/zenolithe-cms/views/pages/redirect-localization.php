<div class="formFieldLarge">
	<label for="redirect_url">URL</label>
	<div class="formFieldError">
	<?php
        if($model->hasError('redirect_url')) {
            echo $model->getErrorCode('redirect_url');
        }
	?>
	</div><br />
	<input type="text" name="redirect_url" value="<?php echo $model->getField('redirect_url'); ?>" />
</div>
<div class="formFieldSmall">
  <label for="redirect_code">Type</label>
  <select name="redirect_code">
  <?php
  	$codes = array(
  		'301' => 'Redir. permanente (301)',
  		'302' => 'Redir. temporaire (302)',
  		'303' => 'Autre adresse (303)'
  	);
  	for($i=301; $i<304; $i++) {
  		if($model->getField('redirect_code') == $i) {
  			echo '<option value="'.$i.'" selected="selected">'.$codes[$i].'</option>';
  		} else {
  			echo '<option value="'.$i.'">'.$codes[$i].'</option>';
  		}
  	}
  ?>
  </select>
</div>
