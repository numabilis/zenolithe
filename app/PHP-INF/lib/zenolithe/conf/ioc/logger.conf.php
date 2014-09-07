<?php
return array(
	'class' => 'org\zenolithe\kernel\log\FileLogger',
	'parameters' => array(
		'level' => '{logger.level}',
		'filePath' => '{application.path}{logger.filepath}',
		'fileTrim' => '{application.path}',
		'dateFormat' => '{logger.dateformat}',
		'timezone' => '{logger.timezone}',
	),
);
?>