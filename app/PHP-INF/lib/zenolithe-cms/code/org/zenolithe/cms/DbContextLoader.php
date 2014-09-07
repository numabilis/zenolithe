<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\routing\Route;
use org\zenolithe\kernel\routing\IRouteResolver;
use org\zenolithe\kernel\bootstrap\Context;
use org\zenolithe\cms\business\Domain;
use org\zenolithe\cms\page\PageModel;

require daf_file('zenolithe/common.daf');
require daf_file('zenolithe/cms/webpage-serving.daf');

class org_zenolithe_cms_DbContextLoader implements IRouteResolver {
	private $iocContainer;
	private $urlBuilder;
	private $modules = array();
	private $pagesDao;

	public function setIocContainer($iocContainer) {
		$this->iocContainer = $iocContainer;
	}
	
	public function setModules($modules) {
		$this->modules = $modules;
	}
	
	public function setUrlBuilder($urlBuilder) {
		$this->urlBuilder = $urlBuilder;
	}
	
	public function setPagesDao($pagesDao) {
		$this->pagesDao = $pagesDao;
	}
	
	public function resolve(Request $request) {
		$route = null;
		$controller = null;
		$interceptors = array();
		
		$page = null;
		
//		$lodgisParameters = $request->getParameter('mobile');
		
		$request->removeAttribute('page');
		
// 		if(!$lodgisParameters || strpos($this->urlBuilder->getbaseUrl(), 'calendrier-locations') || $request->getParameter('emailid') || $request->getParameter('all')) {
			$preview = $request->getParameter('preview');
			if($preview) {
				$previewData = unserialize(file_get_contents($preview));
				$page = $this->pagesDao->build($previewData['page']);
				$request->setAttribute('preview-model', $previewData['model']);
			}
			if($this->modules) {
				foreach($this->modules as $module) {
					if(preg_match('[(.*)/'.$module.'/(.*)]', $request->getLocale().'/'.$request->url)) {
						$moduleUrlPart = substr($request->url, 0, strpos($request->url, '/'.$module.'/') + strlen('/'.$module.'/'));
						$page = $this->pagesDao->getPageByUriAndLang($this->urlBuilder->getbaseUrl(), $moduleUrlPart, $request->getLocale());
						if($page) {
							$this->urlBuilder->setModuleUrlPart($moduleUrlPart);
							$this->urlBuilder->setModuleIndiceUrlPart(substr($request->url, strlen($moduleUrlPart)));
						}
						break;
					}
				}
			}
			if(!$page) {
				$posMod = strpos($request->url, '.mod.');
				$urlLength = strlen($request->url);
				if($posMod) {
					$posSlash = strrpos($request->url, '/', $posMod-$urlLength);
					if($posSlash !== false) {
						$moduleUrlPart = substr($request->url, 0, $posSlash+1);
						$page = $this->pagesDao->getPageByUriAndLang($this->urlBuilder->getbaseUrl(), $moduleUrlPart, $request->getLocale());
						if($page) {
							$this->urlBuilder->setModuleUrlPart($moduleUrlPart);
							$this->urlBuilder->setModuleIndiceUrlPart(substr($request->url, $posSlash+1));
						}
					}
				}
			}
			if(!$page) {
				$page = $this->pagesDao->getPageByUriAndLang($this->urlBuilder->getbaseUrl(), $request->url, $request->getLocale());
			}
			if($page) {
				$this->iocContainer->set('context.domain', $page->getDomain());
				$components = select_components_by_context_id($page->getContextId());
				if($components) {
					$components = array_merge($components, select_interceptors_by_site_id($page->getSiteId()));
				} else {
					$components = select_interceptors_by_site_id($page->getSiteId());
				}
				foreach($components as $component) {
					switch ($component['cpt_role']) {
						case 'interceptor' :
							$cpt = $this->iocContainer->get($component['cpt_class']);
							if(!$cpt) {
								$cpt =  new $component['cpt_class']();
							}
							$cpt->id = $component['cpt_id'];
							$cpt->substituteId = $component['cpt_substitute_id'];
							$cpt->supportedLangs = $component['cpt_supported_langs'];
							$cpt->parameter = $component['cpt_parameter'];
							$cpt->zone = '';
							$cpt->class = '';
							$interceptors[] = $cpt;
							break;
						case 'view-component' :
							$cpt = $this->iocContainer->get($component['cpt_class']);
							if(!$cpt) {
								$cpt =  new $component['cpt_class']();
							}
							$cpt->id = $component['cpt_id'];
							$cpt->substituteId = $component['cpt_substitute_id'];
							$cpt->supportedLangs = $component['cpt_supported_langs'];
							$cpt->parameter = $component['cpt_parameter'];
							$cpt->zone = $component['ctx_zone'];
							$cpt->class = $component['ctx_class'];
							$interceptors[] = $cpt;
					}
				}
				$request->setAttribute('page', $page);
				
				$controller = $this->iocContainer->get($page->getControllerClass());
				if($controller) {
					if($page->getControllerProperties()) {
						$definition = array();
						$properties = explode('&', $page->getControllerProperties());
						foreach ($properties as $property) {
							$pos = strpos($property, '=');
							$propertyName = substr($property, 0, $pos);
							$propertyValue = substr($property, $pos+1);
							$definition['parameters'][$propertyName] = $propertyValue;
						}
						$this->iocContainer->set($page->getControllerClass(), $controller, $definition);
					}
				} else {
					$cc = $page->getControllerClass();
					$controller = new $cc();
					if($page->getControllerProperties()) {
						$properties = explode('&', $page->getControllerProperties());
						foreach ($properties as $property) {
							$pos = strpos($property, '=');
							$propertyName = substr($property, 0, $pos);
							$propertyValue = substr($property, $pos+1);
							$controller->$propertyName = $propertyValue;
						}
					}
				}
				
				$route = new Route();
				$route->setController($controller);
				if($interceptors) {
					$route->addInterceptors($interceptors);
				}
			}
// 		}
		
		return $route;
	}
}
?>
