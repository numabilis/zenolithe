<?php require view_file('admin/top'); ?>

<div id="main">
	<?php
		$types = array();
		foreach($model->get('pages_types') as $pageType) {
			$types[$pageType] = $this->getString('page_'.$pageType.'_name');
		}
		asort($types);
	?>
  <div id="pageTypeChooser" class="popup">
    <div class="content">
      <form method="get" action="edit.php" name="pageTypeChooser">
        <input type="hidden" name="parentGroup" value=""> <label
          for="pageType">Type de page :</label> <select name="pageType">
          <?php foreach ($types as $type => $name) { ?>
            <option value="<?php echo $type; ?>"><?php echo $name; ?></option>
          <?php } ?>
	    		</select>
      </form>
    </div>
  </div>
  
  <div class="pagesRoot">
  	<span class="pageName"><?php echo $model->get('domain_url'); ?></span>
    <?php
			if($model->get('root_pages')) {
			  foreach($model->get('root_pages') as $group => $pages) {
			    echo '<span class="pageType">'.$this->getString('page_'.$pages[$model->getLocale()]['pge_type'].'_name').'</span>';
			    echo '<span class="pageTranslations">';
			    foreach ($model->get('supported_languages') as $lang) {
			      if(isset($pages[$lang])) {
			        echo '&nbsp;<img class="action" src="'.static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png').'" onclick="document.location = \'edit.php?pageId='.$pages[$lang]['pge_id'].'\'" />';
			      } else {
			        echo '&nbsp;<img class="action disabled" src="'.static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png').'" onclick="document.location = \'edit.php?group='.$group.'&lang='.$lang.'\'" />';
			      }
			    }
			    echo '</span>';
			
			    echo '<span class="pageActions">';
			    echo '<img class="action" src="'.static_url('rsrc/cms/images/page_white_add.png').'" onclick="pageAdd(0)">';
			    echo '</span>';
			  }
			}
		?>
  </div>

  <div id="pagesTree" class="pagesList"></div>

  <script type="text/javascript">
		$(document).ready(function() {
			$("#pagesTree").jstree({
				"core" : { "html_titles" : true },
				"plugins" : [ "html_data", "themes" ],
				"html_data" : {
					"ajax" : {
						"url" : "list-sub.php",
						"data" : function(n) {
							id = 0;
							if(n.attr) {
								id = n.attr("id");
							}
							return "groupId="+id;
						}
					}
				},
				"themes" : {"theme" : "zenolithe"}
			}).bind("open_node.jstree", function(e, data) {
        if(typeof(Storage) !== "undefined") {
          openedNodesStr = localStorage.getItem('openedNodes');
          if(openedNodesStr == null) {
            openedNodes = [];
          } else {
          	openedNodes = JSON.parse(openedNodesStr);
          }
          i = openedNodes.indexOf(data.args[0].attr("id"));
          if(i == -1) {
            openedNodes.push(data.args[0].attr("id"));
            localStorage.setItem('openedNodes', JSON.stringify(openedNodes));
          }
				}
			}).bind("close_node.jstree", function(e, data) {
        if(typeof(Storage) !== "undefined") {
	        openedNodesStr = localStorage.getItem('openedNodes');
	        if(openedNodesStr != null) {
	          openedNodes = JSON.parse(openedNodesStr);
	          i = openedNodes.indexOf(data.args[0].attr("id"));
	          if(i >= 0) {
	            openedNodes.splice(i, 1);
	            localStorage.setItem('openedNodes', JSON.stringify(openedNodes));
	          }
	        }
        }
			}).bind("load_node.jstree", function(e, data) {
         if(typeof(Storage) !== "undefined") {
	         openedNodesStr = localStorage.getItem('openedNodes');
	         if(openedNodesStr != null) {
	           openedNodes = JSON.parse(openedNodesStr);
	           children = data.inst._get_children(data.args[0]);
	           $(children).each(function(index, value) {
	               id = $(value).attr("id");
	               i = openedNodes.indexOf(id);
	               if(i >= 0) {
	                 data.inst.open_node(value);
	               }
	           });
	         }
         }
			});
		});
	</script>

</div>

<?php require view_file('admin/bottom'); ?>
