<?php require view_file('admin/top'); ?>

<div id="main">
	<?php
		$config = false;
		require view_file('admin/pages/menu');
	?>
  <form method="post" enctype="multipart/form-data" action="edit.php">
  	<input type="hidden" name="zenolithe_uname" value="<?php echo $model->getField('zenolithe_uname'); ?>" />
    <div class="formBlock">
      <div class="formFieldLarge">
        <label for="page_uri">URL</label>
        <div class="formFieldError">
        <?php
	        if($model->hasError('page_uri')) {
	        	echo $model->getErrorCode('page_uri');
	        }
        ?>
        </div>
        <div class="pseudo-input">
          <div class="before-input"><?php echo $model->getAttribute('domain_url').$model->getAttribute('page_lang').'/'; ?></div>
          <input type="text" name="page_uri" value="<?php echo $model->getField('page_uri'); ?>" />
        </div>
      </div>

      <div class="formFieldSmall">
        <label for="page_status">&Eacute;tat</label>
        <select name="page_status">
          <?php
	          if($model->getField('page_status') == PAGE_STATUS_DRAFT) {
	          	echo '<option selected="selected" value="'.PAGE_STATUS_DRAFT.'">Brouillon</option>';
	          } else {
	          	echo '<option  value="'.PAGE_STATUS_DRAFT.'">Brouillon</option>';
	          }
	          if($model->getField('page_status') == PAGE_STATUS_PUBLISHED) {
	          	echo '<option selected="selected" value="'.PAGE_STATUS_PUBLISHED.'">Publié</option>';
	          } else {
	          	echo '<option  value="'.PAGE_STATUS_PUBLISHED.'">Publié</option>';
	          }
	          if($model->getField('page_status') == PAGE_STATUS_PLANNED) {
	          	echo '<option selected="selected" value="'.PAGE_STATUS_PLANNED.'">Planifié</option>';
	          } else {
	          	echo '<option  value="'.PAGE_STATUS_PLANNED.'">Planifié</option>';
	          }
	          if($model->getField('page_status') == PAGE_STATUS_OFFLINE) {
	          	echo '<option selected="selected" value="'.PAGE_STATUS_OFFLINE.'">Hors ligne</option>';
	          } else {
	          	echo '<option  value="'.PAGE_STATUS_OFFLINE.'">Hors ligne</option>';
	          }
          ?>
        </select>
      </div>

      <div class="formFieldLarge">
        <label for="page_title">Titre</label>
        <div class="formFieldError">
        <?php
	        if($model->hasError('page_title')) {
	        	echo $model->getErrorCode('page_title');
	        }
        ?>
        </div>
        <input type="text" name="page_title" value="<?php echo $model->getField('page_title'); ?>" />
      </div>

      <div class="formFieldSmall">
        <label for="page_publish_date">Date de publication</label>
        <input type="text" name="page_publish_date" id="page_publish_date" value="<?php echo $model->getField('page_publish_date'); ?>" />
      </div>
      <script type="text/javascript">
    		$('#page_publish_date').datetimepicker({
    			timeFormat: 'hh:mm'
    		});
	    </script>

      <div class="formFieldLarge">
        <label for="page_short_title">Titre court (pour les menus et le fil d'Ariane)</label>
        <div class="formFieldError">
        <?php
	        if($model->hasError('page_short_title')) {
	        	echo $model->getErrorCode('page_short_title');
	        }
        ?>
        </div>
        <input type="text" name="page_short_title" value="<?php echo $model->getField('page_short_title'); ?>" />
      </div>

      <div class="formFieldSmall">
        <label for="page_robots">Menu</label><br />
 	    	<?php
   				if($model->getField('page_menu') == 't') {
     				echo '<input checked="checked" type="checkbox" name="page_menu" value="1" />menu';
     			} else {
     				echo '<input type="checkbox" name="page_menu" value="1" />menu';
     			}
     		?>
     	</div>

      <div class="formFieldToggle">
        <a href="#" onclick="$('#meta').slideToggle('slow'); return false;">Meta</a>
      </div>

      <div id="meta" class="formFieldToggled">
        <div class="formFieldLarge">
          <label for="page_meta_title">Titre</label>
          <input type="text" name="page_meta_title" value="<?php echo $model->getField('page_meta_title'); ?>" />
        </div>
        <div class="formFieldLarge">
          <label for="page_description">Description</label>
          <textarea name="page_description"><?php echo $model->getField('page_description'); ?></textarea>
        </div>
        <div class="formFieldSmall">
          <label for="page_robots">Robots</label><br />
 	    		<?php	if($model->getField('page_robots_noindex')) { ?>
 					<input checked="checked" type="checkbox" name="page_robots_noindex" value="1" />&nbsp;noindex<br />
 					<?php	} else { ?>
        	<input type="checkbox" name="page_robots_noindex" value="1" />&nbsp;noindex<br />
        	<?php	} ?>
          <?php if($model->getField('page_robots_nofollow')) { ?>
        	<input checked="checked" type="checkbox" name="page_robots_nofollow" value="1" />&nbsp;nofollow
        	<?php	} else { ?>
        	<input type="checkbox" name="page_robots_nofollow" value="1" />&nbsp;nofollow
        	<?php	}	?>
        </div>
        <div class="formFieldLarge">
          <label for="page_keywords">Mots clés</label>
          <input type="text" name="page_keywords" value="<?php echo $model->getField('page_keywords'); ?>" />
        </div>
      </div>

    </div>
    
		<?php
    	if($model->getAttribute('page_localization_view')) {
    		echo '<div class="formBlock">';
    		require view_file($model->getAttribute('page_localization_view'));
    		echo '</div>';
		  }
		  foreach($model->getAttribute('components_localizers') as $type => $cpt) {
    		echo '<div class="formBlock">';
    		echo '<div class="title">'.$this->getString('component_'.$type.'_name').'</div>';
    		render_view($cpt->getViewName(), $cpt);
    		echo '</div>';
		  }
		?>
    
   	<div class="formActions">
      <input class="button" type="submit" name="save" value="Enregistrer" />
      <?php if($model->getAttribute('preview_allowed')) { ?>
      <input class="button" type="submit" name="preview" value="Prévisualiser" />
      <?php } ?>
    </div>
    
	</form>
  
</div>

<script type="text/javascript">
  $(function(){
	  $("#meta").slideUp("fast");
  });
</script>

<?php if($model->hasError('preview')) { ?>
<script type="text/javascript">
  $(function(){
	  window.open('<?php echo $model->getErrorCode('preview'); ?>', 'preview');
  });
</script>
<?php } ?>
<?php require view_file('admin/bottom'); ?>
