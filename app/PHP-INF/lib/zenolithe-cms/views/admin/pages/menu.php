<div class="tabs" id="pageTabs">
	<div class="first"><a href="list.php"><img src="<?php echo static_url('rsrc/cms/images/document-tree.png'); ?>" /></a></div>
    <ul>
<?php
$tabIndex = 0;
if($model->getAttribute('page_lang')) {
  $pageLang = $model->getAttribute('page_lang');
} else {
  $pageLang = 'none';
}
$translations = $model->getAttribute('translations');
foreach($model->getAttribute('supported_languages') as $lang) {
  if($pageLang == $lang) {
    echo '<li><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
    $selectedTab = $tabIndex;
  } else if(isset($translations[$lang])) {
    echo '<li><a href="edit.php?pageId=' . $translations[$lang]['pge_id']. '" title="edit_pageId_'.$translations[$lang]['pge_id']. '">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
  } else if($model->getAttribute('page_group')) {
    echo '<li><a href="edit.php?group=' . $model->getAttribute('page_group').'&lang='.$lang.'" title="edit_group_'.$model->getAttribute('page_group').'_' . $lang . '">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
  } else {
    echo '<li><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
  }
  $tabIndex++;
}

if($model->getAttribute('configurable') && count($translations)) {
  echo '<li class="last"><a href="configure.php?group='.$model->getAttribute('page_group').'" title="configure_'.$model->getAttribute('page_group').'">&nbsp;<img src="' . static_url('rsrc/cms/images/cog.png') . '" />&nbsp;</a></li>';
} else {
  echo '<li class="last"><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/cog.png') . '" />&nbsp;</a></li>';
  if(isset($configure)) {
    $selectedTab = $tabIndex;
  }
}
?>

	</ul>
</div>
<script>
$("#pageTabs").tabs({selected: <?php echo $selectedTab; ?>,
		select: function(event, ui) {
			args = ui.tab.href.substr(ui.tab.href.lastIndexOf("#")+1).split("_");
			if(args[0] == 'edit') {
				if(args[1] == 'pageId') {
					url = args[0] + ".php?pageId=" + args[2];
				} else {
					url = args[0] + ".php?group=" + args[2] + "&lang=" + args[3];
				}
				
			} else {
				url = args[0] + ".php?group=" + args[1];
			}
			//console.log(url);
			document.location = url;
			return false;
		}
});
</script>
