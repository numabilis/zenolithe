<?php
return array(
	'user.prefs.default.background.image' => 'heaven1.jpg',
	'context.debug' => false,
	'database.engine' => 'mysql',
	'database.host' => '',
	'database.user' => '',
	'database.password' => '',
	'database.name' => '',
	'logger.level' => 3,
	'logger.filepath' => '../logs/zenolithe.log',
	'logger.dateformat' => 'm/d/Y H:i:s',
	'logger.timezone' => 'Europe/Paris',
	'cache.active' => true,
	'cache.clearonexit' => false,
	'cache.type' => 'xCache',
	'locale.default' => 'en',
	'locale.supportedlocales' => 'en/fr/',
	'mail.host' => '127.0.0.1',
	'mail.port' => '25',
/*
	'includes' => array(
			'lib/hacks/functions.php',
			'lib/zenolithe-cms/code/dafs/pg/zenolithe/common.daf.php',
			'lib/zenolithe-cms/conf/definitions/acl.conf.php'
	),
*/
	'error.view' => 'errors/error',
	'error.404uri' => 'errors/404.php',
	'zenolithe.modules.conf' => 'conf/modules/',
	'zenolithe.components.conf' => 'conf/components/',
	'zenolithe.templates.conf' => 'conf/templates/',
	'zenolithe.templates.path' => 'views/templates/',
	'zenolithe.pages.conf' => 'conf/pages/',
	'zenolithe.views.path' => 'views/',
	'zenolithe.routes.path' => 'routes/',
	'application.base' => '/',
	'ioc.init' => array('loggerWrapper'),
	'includes' => array(),
);
?>