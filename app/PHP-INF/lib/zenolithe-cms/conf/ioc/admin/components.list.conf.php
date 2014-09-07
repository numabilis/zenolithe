<?php
return array(
	'class' => 'org\zenolithe\cms\components\admin\ComponentsListController',
	'parameters' => array(
		'view' => 'admin/components/list',
		'componentRole' => 'view-component',
		'zenolitheRoot' => '{zenolithe.root}',
		'componentsPath' => '{zenolithe.components.conf}'
	)
);
?>