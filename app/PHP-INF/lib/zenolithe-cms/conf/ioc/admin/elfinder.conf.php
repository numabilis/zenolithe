<?php
return array(
	'class' => 'org\zenolithe\cms\plugins\PluginController',
	'parameters' => array(
		'requiredFile' => 'code/elfinder/connector.php',
		'variables' => array(
				'mediasPath' => '{application.path}medias/',
				'mediasUrl' => '{application.base}medias/'
		)
	)
);
?>