<?php
namespace org\zenolithe\kernel\mvc;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\ioc\IocContainer;
use org\zenolithe\kernel\bootstrap\IModule;

class Application implements IModule {
	private $errorView;
	private $error404Uri;
	private $iocContainer;
	private $error404Forwarded = false;

	public function setErrorView($errorView) {
		$this->errorView = $errorView;
	}

	public function setError404Uri($error404Uri) {
		$this->error404Uri = $error404Uri;
	}

	public function setIocContainer(IocContainer $iocContainer) {
		$this->iocContainer = $iocContainer;
	}

	public function init() {
	}

	public function setUp() {
	}

	public function run() {
		do {
			$request = new Request();
			$this->iocContainer->set('context.request', $request);
			if(isset($_REQUEST ['u'])) {
				$request->url = trim(preg_replace('/\s+/', ' ', $_REQUEST ['u']));
			} else {
				$request->url = '';
			}
			$this->processRequest($request);
			if($request->isForwarded()) {
				if(! $this->iocContainer->get('context.request.error')) {
					$this->iocContainer->set('context.request.error', $request);
				}
				$_REQUEST ['u'] = $request->getForwardURL();
			}
		} while ( $request->isForwarded() );
	}

	private function processRequest(Request &$request) {
		$route = null;
		$model = null;
		$view = null;
		
		try {
			$locale = $this->iocContainer->get('localeResolver')->resolve($request);
			$request->setLocale($locale);
			$route = $this->iocContainer->get('router')->resolve($request);
			$viewResolver = $this->iocContainer->get('viewResolver');
			if(! $route) {
				$view_name = substr($request->url, 0, strrpos($request->url, "."));
				$view = $viewResolver->resolve($view_name, $locale);
				if($view == null) {
					if($request->url == $this->error404Uri) {
						error('404 for ' . $this->error404Uri . ' for ' . $_SERVER ['REMOTE_ADDR']);
					} else if(strrpos($request->url, 'index.php') !== false) {
						$_GET = array ();
						$_POST = array ();
						if(! $this->error404Forwarded) {
							$this->error404Forwarded = true;
							$request->forward($this->error404Uri);
						}
						if(! isset($_SERVER ['SCRIPT_URL'])) {
							$_SERVER ['SCRIPT_URL'] = '';
						}
						if($_SERVER ['QUERY_STRING']) {
							error('404 for ' . $_SERVER ['HTTP_HOST'] . $_SERVER ['SCRIPT_URL'] . '?' . $_SERVER ['QUERY_STRING'] . ' for ' . $_SERVER ['REMOTE_ADDR']);
						} else {
							error('404 for ' . $_SERVER ['HTTP_HOST'] . $_SERVER ['SCRIPT_URL'] . ' for ' . $_SERVER ['REMOTE_ADDR']);
						}
					} else if(strrpos($request->url, '/') == (strlen($request->url) - 1)) {
						$request->forward($request->url . 'index.php');
					} else {
						$request->forward($request->url . '/');
					}
				}
			}
			
			if($view) {
				$view->render($model);
			} else if($route) {
				$intercepted = false;
				foreach($route->getInterceptors() as $interceptor) {
					if($model == null) {
						$model = $interceptor->preHandle($request, $route->getController());
						if($model != null) {
							$intercepted = true;
						}
					}
				}
				if(! $intercepted) {
					$model = $route->getController()->handleRequest($request);
					if(! $request->isRedirected()) {
						if($model == null) {
							$model = new SimpleModel();
						}
						foreach($route->getInterceptors() as $interceptor) {
							$interceptor->postHandle($request, $route->getController(), $model);
						}
					}
				}
				if(! $request->isForwarded() && ! $request->isRedirected()) {
					if(! $model->getViewName()) {
						$model->setViewName($request->url);
					}
					$view = $viewResolver->resolve($model->getViewName(), $locale);
					// comportement si resolve view_name echoue :
					if($view == null) {
						if(! $this->error404Forwarded) {
							$this->error404Forwarded = true;
							$request->forward($this->error404Uri);
						}
						if(! isset($_SERVER ['SCRIPT_URL'])) {
							$_SERVER ['SCRIPT_URL'] = '';
						}
						if($_SERVER ['QUERY_STRING']) {
							error('404 for ' . $_SERVER ['HTTP_HOST'] . $_SERVER ['SCRIPT_URL'] . '?' . $_SERVER ['QUERY_STRING'] . ' for ' . $_SERVER ['REMOTE_ADDR'] . ' (no view "' . $model->getViewName() . '" found)');
						} else {
							error('404 for ' . $_SERVER ['HTTP_HOST'] . $_SERVER ['SCRIPT_URL'] . ' for ' . $_SERVER ['REMOTE_ADDR'] . ' (no view "' . $model->getViewName() . '" found)');
						}
					} else {
						if(! $model->getLocale()) {
							$model->setLocale($request->getLocale());
						}
						$view->render($model);
					}
				}
				if(! $intercepted) {
					foreach($route->getInterceptors() as $interceptor) {
						$interceptor->afterCompletion($request, $route->getController());
					}
				}
			}
			if($request->isRedirected()) {
				// force GET redirection in case new url = old url
				header('HTTP/1.1 ' . $request->getRedirectCode() . ' ' . $request->getRedirectMessage());
				header('Location: ' . $request->getRedirectURL(), true, $request->getRedirectCode());
			}
		} catch ( Exception $e ) {
			exception_error($e);
			$view = $viewResolver->resolve($this->errorView, $locale);
			if(! $model->getLocale()) {
				$model->setLocale($request->getLocale());
			}
			$view->render($model, $e);
		}
	}

	public function tearDown() {
	}

	public function finish() {
	}
}
?>
