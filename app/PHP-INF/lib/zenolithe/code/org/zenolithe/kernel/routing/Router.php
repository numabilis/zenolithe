<?php
namespace org\zenolithe\kernel\routing;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\bootstrap\Context;

class Router {
	private $resolvers;
	
	public function setResolvers($resolvers) {
		$this->resolvers = $resolvers;
	}

	public function resolve(Request $request) {
		$route = null;

		foreach($this->resolvers as $resolver) {
			$route = $resolver->resolve($request);
			if($route) {
				break;
			}
		}

		return $route;
	}
}
?>
