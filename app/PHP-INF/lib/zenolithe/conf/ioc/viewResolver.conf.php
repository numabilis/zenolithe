<?php
return array(
	'class' => 'org\zenolithe\kernel\mvc\views\SimpleViewResolver',
	'parameters' => array(
		'viewsPath' => '{zenolithe.views.path}'
	),
	'injected' => array(
		'stringResolver' => 'stringResolver'
	)
);
?>