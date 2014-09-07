<?php
// namespace org\zenolithe\cms;

class org_zenolithe_cms_ComponentRegistry {
	static private $registry = array();
	
	static public function put($name, $object) {
		self::$registry[$name] = $object;
	}
	
	static public function get($name) {
		$object = null;
		
		if(isset(self::$registry[$name])) {
			$object = self::$registry[$name];
		}
		
		return $object;
	}
}
?>