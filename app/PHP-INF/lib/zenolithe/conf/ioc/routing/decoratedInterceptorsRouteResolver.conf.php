<?php
return array(
	'class' => 'org\zenolithe\kernel\routing\DecoratedInterceptorsRouteResolver',
 	'injected' => array(
 		'iocContainer' => 'ioc.container'
 	),
	'parameters' => array(
		'routesPath' => '{zenolithe.routes.path}'
	)
);
?>