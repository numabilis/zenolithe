<?php
namespace org\zenolithe\kernel\routing;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\routing\Route;
use org\zenolithe\kernel\routing\IRouteResolver;

class BasicRouteResolver implements IRouteResolver {
	private $routesPath;
	
	public function setRoutesPath($routesPath) {
		$this->routesPath = $routesPath;
	}
	
	public function resolve(Request $request) {
		$route = null;
		
		$filename = stream_resolve_include_path($this->routesPath.$request->url);
		if(is_file($filename)) {
			require $filename;
			$controller = require $filename;
			$route = new Route();
			$route->setController($controller);
		}
// 		TODO : Refactor
// 		$filename = stream_resolve_include_path($this->routesPath.$request->url);
// 		if(is_file($filename)) {
// 			$routeDefinition = require $filename;
// 			$route = new Route();
// 			$route->setController($routeDefinition['controller']);
// 			if(isset($routeDefinition['interceptors'])) {
// 				$route->addInterceptors($routeDefinition['interceptors']);
// 			}
// 		}
		
		return $route;
	}
}
?>
