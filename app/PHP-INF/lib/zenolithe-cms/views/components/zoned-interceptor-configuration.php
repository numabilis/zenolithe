<div class="formFieldSmall">
	<label for="zone">Zone</label>
	<select name="zone">
  <?php
  	foreach($model->getAttribute('zones') as $zoneName => $zoneValue) {
  		if($model->getField('zone') == $zoneValue) {
  			echo '<option selected="selected" value="'.$zoneValue.'">'.$zoneName.'</option>';
  		} else {
  			echo '<option  value="'.$zoneValue.'">'.$zoneName.'</option>';
  		}
  	}
  ?>
  </select>
</div>
