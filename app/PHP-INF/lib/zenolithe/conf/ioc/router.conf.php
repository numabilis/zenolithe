<?php
return array(
	'class' => 'org\zenolithe\kernel\routing\Router',
	'injected' => array(
		'resolvers' => array(
 			'routing/dbRouteResolver',
				'routing/decoratedInterceptorsRouteResolver',
// 			'routing/abRouteResolver',
		)
	)
// 	'parameters' => array('host' => 'localhost')
);
?>