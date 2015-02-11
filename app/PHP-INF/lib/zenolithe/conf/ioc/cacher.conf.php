<?php
return array(
	'name' => 'cacher',
	'class' => 'org\zenolithe\kernel\cache\Cacher',
	'scope' => 'application',
	'injected' => array(
		'cache' => 'caching/{cache.type}'
	)
);
