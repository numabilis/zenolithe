<?php
return array(
	'class' => 'org\zenolithe\cms\components\admin\ComponentDeleteController',
	'parameters' => array(
		'formView' => 'admin/plugins/delete',
		'componentRole' => 'interceptor',
		'componentsPath' => '{zenolithe.root}{zenolithe.components.conf}'
	)
);
?>