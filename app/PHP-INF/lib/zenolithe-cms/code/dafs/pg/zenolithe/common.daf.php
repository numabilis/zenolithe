<?php
/*
 *
* Created on 08 march 2012 by David Jourand
*
*/
use org\zenolithe\kernel\ioc\IocContainer;

function db_connect() {
	static $connected = false;
	static $cnx;

	if(!$connected)	{
		$container = IocContainer::getInstance();
		$db = $container->get('database');
		$cnx = $db->connect();
		
		if($cnx) {
			$connected = true;
		}	else {
			$cnx = null;
		}
	}

	return $cnx;
}

function quote_smart($value) {
	// Protection si ce n'est pas un entier
	if (!is_numeric($value)) {
		$value = "'" . pg_escape_string($value) . "'";
	}

	return $value;
}

function quote_force($value) {
	// Protection si ce n'est pas un entier
	$value = "'" . pg_escape_string($value) . "'";

	return $value;
}
?>
