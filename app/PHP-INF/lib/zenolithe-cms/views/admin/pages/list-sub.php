<ul>
<?php
$modelPages = $model->get('pages');

if($modelPages) {
	foreach($modelPages as $group => $pages) {
		if(count($pages['children'])) {
			echo '<li class="jstree-closed" id="'.$group.'">';
		} else {
			echo '<li id="'.$group.'">';
		}
		echo '<a class="pageName">'.$pages[$model->getLocale()]['pge_short_title'].'</a>';

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
		echo '<img class="action" src="'.static_url('rsrc/cms/images/arrow-down.png').'" onclick="document.location=\'reorder.php?action=down&group='.$group.'\'">';
		echo '<img class="action" src="'.static_url('rsrc/cms/images/arrow-up.png').'" onclick="document.location=\'reorder.php?action=up&group='.$group.'\'">';
		echo '<img class="action" src="'.static_url('rsrc/cms/images/page_white_add.png').'" onclick="pageAdd('.$group.')">';
		echo '</span>';

		echo '</li>';
	}
}
?>
</ul>
