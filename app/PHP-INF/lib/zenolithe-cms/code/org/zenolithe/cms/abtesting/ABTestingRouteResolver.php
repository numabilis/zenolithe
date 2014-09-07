<?php
namespace org\zenolithe\cms\abtesting;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\routing\Route;
use org\zenolithe\kernel\routing\IRouteResolver;
use org\zenolithe\kernel\bootstrap\Context;
use org\zenolithe\cms\business\Domain;
use org\zenolithe\cms\page\PageModel;

require daf_file('zenolithe/common.daf');
require daf_file('zenolithe/cms/webpage-serving.daf');

class ABTestingRouteResolver implements IRouteResolver {
	private $iocContainer;
	private $urlBuilder;
	private $abtestsDao;
	private $pagesDao;
	private $session;
	
	public function setIocContainer($iocContainer) {
		$this->iocContainer = $iocContainer;
	}
	
	public function setUrlBuilder($urlBuilder) {
		$this->urlBuilder = $urlBuilder;
	}
	
	public function setABTestsDao($abtestsDao) {
		$this->abtestsDao = $abtestsDao;
	}
	
	public function setPagesDao($pagesDao) {
		$this->pagesDao = $pagesDao;
	}
	
	public function setSession($session) {
		$this->session = $session;
	}
	
	public function resolve(Request $request) {
		$route = null;
		$controller = null;
		$interceptors = array();
		$page = null;
		
		$request->removeAttribute('page');
		$abtest = $this->abtestsDao->getTestByUriAndLang($this->urlBuilder->getbaseUrl(), $request->url, $request->getLocale());
		if($abtest) {
			$group = $this->session->getAttribute('abtests.'.$abtest->getName().'.group');
			if(!$group) {
				$s = new ABTestRandomStrategy();
				$group = $s->getGroup($abtest);
				$this->session->setAttribute('abtests.'.$abtest->getName().'.group', $group);
			}
			$request->setAttribute('abtests.'.$abtest->getName().'.group', $group);
			
			if($group != IABTest::GROUP_CONTROL) {
				$page = $this->pagesDao->getPageByUriAndLang($this->urlBuilder->getbaseUrl(), $request->url, $request->getLocale());
				$abPage = $this->pagesDao->getPageById($abtest->getPageId());
				if($page && $abPage) {
					$page->controllerProperties = $abPage->controllerProperties;
					$page->contextId = $abPage->contextId;
					$page->title = $abPage->title;
					$page->description = $abPage->description;
					$page->keywords = $abPage->keywords;
					$page->robots = $abPage->robots;
					$page->controllerClass = $abPage->controllerClass;
					$page->type = $abPage->type;
					$page->metaTitle = $abPage->metaTitle;
					$page->shortTitle = $abPage->shortTitle;
				
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
					$cpt = $this->iocContainer->get('templating');
					$cpt->addDesktopTemplate('orange-ab');
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
			}
		}
		
		return $route;
	}
}
?>
