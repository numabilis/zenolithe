<?php
return array(
	'name' => 'cache',
	'class' => 'org\zenolithe\kernel\cache\XCache',
	'scope' => 'application',
	'injected' => array(
		'active' => 'cache.active',
		'clearOnExit' => 'cache.clearonexit'
	)
);
