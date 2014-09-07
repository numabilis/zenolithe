<?php
return array(
	'interceptors' => array(
		array(
			'interceptor' => 'interceptors/access.control',
			'parameters' => array(
				'action' => ACL_ACTION_ADMIN,
				'loginUri' => 'login.php',
				'rejectView' => 'admin/notallowed'
			)
		),
		array(
			'interceptor' => 'interceptors/domains.switch',
			'parameters' => array(
				'switchUrl' => 'admin/domains/switch.php',
				'protectedUrls' => '[^admin/domains/(.)*$]'
			)
		)
	)
);
?>
