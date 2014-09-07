<?php
namespace org\zenolithe\cms\page;

use org\zenolithe\cms\business\Domain;
use org\zenolithe\kernel\mvc\SimpleModel;

class PageModel extends SimpleModel implements IPageModel {
	public $id;
	public $siteId;
	public $controllerProperties;
	public $contextId;
	public $group;
	public $parentGroup;
	public $controllerClass;
	public $type;
	public $status;
	public $publishDate;
	public $uri;
	public $uriPart;
	public $order;
	public $showInMenu;
	private $domain;
	
	public $lang;
	private $metaScriptLinks = array();
	public $title;
	public $description;
	public $keywords;
	public $robots;
	public $metaTitle;
	public $shortTitle;
	private $nextPage;
	private $previousPage;
	private $isHome = false;
	
	private $canonical;
	private $content = array();
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setUri($uri) {
		$this->uri = $uri;
	}
	
	public function setUriPart($uriPart) {
		$this->uriPart = $uriPart;
	}
	
	public function getSiteId() {
		return $this->siteId;
	}
	
	public function setSiteId($siteId) {
		$this->siteId = $siteId;
	}
	
	public function getContextId() {
		return $this->contextId;
	}
	
	public function setContextId($contextId) {
		$this->contextId = $contextId;
	}
	
	public function getControllerClass() {
		return $this->controllerClass;
	}
	
	public function setControllerClass($controllerClass) {
		$this->controllerClass = $controllerClass;
	}
	
	public function getControllerProperties() {
		return $this->controllerProperties;
	}
	
	public function setControllerProperties($controllerProperties) {
		$this->controllerProperties = $controllerProperties;
	}
	
	public function getCanonical() {
		return $this->canonical;
	}
	
	public function setCanonical($canonical) {
		$this->canonical = $canonical;
	}
	
	public function getDomain() {
		return $this->domain;
	}
	
	public function setDomain(Domain $domain) {
		$this->domain = $domain;
	}
	
	public function addContent($zone, $content) {
		$this->content[$zone][] = $content;
	}
	
	public function getContent($zone) {
		$content = array();
		
		if(isset($this->content[$zone])) {
			$content = $this->content[$zone];
		}
		
		return $content;
	}
	
	public function getShortTitle() {
		return $this->shortTitle;
	}
	
	public function setShortTitle($shortTitle) {
		$this->shortTitle = $shortTitle;
	}
	
	public function setNextPage($nextPage) {
		$this->nextPage = $nextPage;
	}
	
	public function setPreviousPage($previousPage) {
		$this->previousPage = $previousPage;
	}
	
	public function addMetaScriptLink($scriptLink) {
		$this->metaScriptLinks[] = $scriptLink;
	}

	public function getMetaTitle() {
		return $this->metaTitle;
	}
	
	public function getMetaDescription() {
		return $this->description;
	}
	
	public function isHome() {
		if($this->isHome === false) {
			$this->isHome = (($this->uri == '') || ($this->uri == '/'));
		}
	}
	
	public function setHome($isHome) {
		$this->isHome = $isHome;
	}
}
?>