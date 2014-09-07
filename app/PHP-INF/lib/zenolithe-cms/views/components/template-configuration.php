<div class="formFieldSmall">
	<label for="desktopTemplateName">Gabarit desktop</label>
	<select name="desktopTemplateName">
  <?php
  	$templates = $model->getAttribute('templates');
  	foreach($templates['desktop'] as $templateName) {
  		if($model->getField('desktopTemplateName') == $templateName) {
  			echo '<option selected="selected" value="'.$templateName.'">'.get_string('template_'.$templateName.'_name').'</option>';
  		} else {
  			echo '<option value="'.$templateName.'">'.get_string('template_'.$templateName.'_name').'</option>';
  		}
  	}
  ?>
  </select>
</div>
<div class="formFieldSmall">
  <label for="mobileTemplateName">Gabarit mobile</label>
  <select name="mobileTemplateName">
	  <option value=""></option>
	  <?php
	    foreach($templates['mobile'] as $templateName) {
	      if($model->getField('mobileTemplateName') == $templateName) {
	        echo '<option selected="selected" value="'.$templateName.'">'.get_string('template_'.$templateName.'_name').'</option>';
	      } else {
	        echo '<option value="'.$templateName.'">'.get_string('template_'.$templateName.'_name').'</option>';
	      }
	    }
	  ?>
  </select>
</div>
