<?php
return array(
  'class' => 'org\zenolithe\cms\components\admin\ComponentsListController',
  'parameters' => array(
    'view' => 'admin/plugins/list',
    'componentRole' => 'interceptor',
		'zenolitheRoot' => '{zenolithe.root}',
		'componentsPath' => '{zenolithe.components.conf}'
  )
);
?>