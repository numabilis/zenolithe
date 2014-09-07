<?php
return array(
	'class' => 'org\zenolithe\cms\abtesting\ABTestingRouteResolver',
	'injected' => array(
		'iocContainer' => 'ioc.container',
		'urlBuilder' => 'urlBuilder',
		'aBTestsDao' => 'cms/daos.abtests.serving',
		'pagesDao' => 'cms/daos.pages.serving',
		'session' => 'session'
	)
);
?>
