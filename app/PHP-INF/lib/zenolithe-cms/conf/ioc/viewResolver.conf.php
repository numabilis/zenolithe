<?php
return array(
	'class' => 'org\zenolithe\cms\templating\TemplateViewResolver',
  'injected' => array(
    'stringResolver' => 'stringResolver'
  ),
	'parameters' => array(
		'templatesPath' => '{zenolithe.templates.path}',
		'viewsPath' => '{zenolithe.views.path}'
	)
);
?>