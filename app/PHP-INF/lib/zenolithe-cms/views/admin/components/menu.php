<div class="tabs" id="componentTabs">
	<div class="first"><a href="list.php"><img src="<?php echo static_url('rsrc/cms/images/application_view_list.png'); ?>" /></a></div>
    <ul>
<?php
$tabIndex = 0;
if(!$model->getAttribute('cpt_lang')) {
    $model->setAttribute('cpt_lang', 'none');
}
if($model->getAttribute('cpt_id') && $model->getAttribute('cpt_localizable')) {
    foreach($model->getAttribute('supported_langs') as $lang) {
        if($model->getAttribute('cpt_lang') == $lang) {
            echo '<li><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
            $selectedTab = $tabIndex;
        } else {
            echo '<li id="'.$lang.'"><a href="edit.php?lang='.$lang.'&id='.$model->getAttribute('cpt_id').'" title="edit_'.$model->getAttribute('cpt_id').'_'.$lang.'">&nbsp;<img src="'.static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png').'" />&nbsp;</a></li>';
        }
        $tabIndex++;
    }
    if(!$config) {
        echo '<li class="last"><a href="configure.php?id='.$model->getAttribute('cpt_id').'" title="configure_'.$model->getAttribute('cpt_id').'">&nbsp;<img src="' . static_url('rsrc/cms/images/cog.png') . '" />&nbsp;</a></li>';
    } else {
        echo '<li class="last"><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/cog.png') . '" />&nbsp;</a></li>';
        $selectedTab = $tabIndex;
    }
    $tabIndex++;
} else {
    foreach($model->getAttribute('supported_langs') as $lang) {
        echo '<li><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/flags/'.str_replace('-', '_', $lang).'.png') . '" />&nbsp;</a></li>';
        $tabIndex++;
    }
    echo '<li class="last"><a href="#">&nbsp;<img src="' . static_url('rsrc/cms/images/cog.png') . '" />&nbsp;</a></li>';
    $selectedTab = $tabIndex;
    $tabIndex++;
}
?>
	</ul>
</div>
<script>
$( "#componentTabs" ).tabs({ selected: <?php echo $selectedTab; ?>,
		select: function(event, ui) {
			args = ui.tab.href.substr(ui.tab.href.lastIndexOf("#")+1).split("_");
			if(args[0] == 'edit') {
				url = args[0] + ".php?id=" + args[1] + "&lang=" + args[2];
			} else {
				url = args[0] + ".php?id=" + args[1];
			}
			document.location = url;
			return false;
		}
});
</script>
