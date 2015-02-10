<?php
namespace org\zenolithe\kernel\routing;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\bootstrap\Context;

class DecoratedInterceptorsRouteResolver implements IRouteResolver {
	private $iocContainer;
	private $routesPath;

	public function setRoutesPath($routesPath) {
		$this->routesPath = $routesPath;
	}

	public function setIocContainer($iocContainer) {
		$this->iocContainer = $iocContainer;
	}

	public function resolve(Request $request) {
		$route = null;
		$controller = null;
		$interceptors = array ();
		$routesDir = $this->routesPath . $request->getLocale() . '/';
		$filename = stream_resolve_include_path($routesDir . $request->url);
		if(!$filename) {
			$routesDir = $this->routesPath;
			$filename = stream_resolve_include_path($routesDir . $request->url);
		}
		if(is_file($filename)) {
			$filterFilename = stream_resolve_include_path($routesDir . 'zenolithe-filter.php');
			if(is_file($filterFilename)) {
				$defs = require ($filterFilename);
				if(isset($defs['interceptors'])) {
					foreach($defs['interceptors'] as $def) {
						$interceptors[] = $this->iocContainer->register($interceptorDef);
					}
				}
			}
			$dirs = explode('/', $request->url);
			array_pop($dirs);
			$dirpath = '';
			foreach($dirs as $dir) {
				$dirpath .= $dir . '/';
				$filterFilename = stream_resolve_include_path($routesDir . $dirpath . 'zenolithe-filter.php');
				if(is_file($filterFilename)) {
					$defs = require ($filterFilename);
					if(isset($defs['interceptors'])) {
						foreach($defs['interceptors'] as $def) {
							$interceptors[] = $this->iocContainer->register($interceptorDef);
						}
					}
				}
			}
			$def = require ($filename);
			if(is_array($def)) {
				$controller = $this->iocContainer->register($def['controller']);
				if(isset($def['interceptors'])) {
					foreach($def['interceptors'] as $interceptorDef) {
						$interceptors[] = $this->iocContainer->register($interceptorDef);
					}
				}
			}
			$route = new Route();
			$route->setController($controller);
			$route->addInterceptors($interceptors);
		}
		
		return $route;
	}
}
?>
