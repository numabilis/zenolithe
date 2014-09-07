<?php
namespace org\zenolithe\cms\abtesting;

class ABTest implements IABTest {
	private $id;
	private $name;
	private $lang;
	private $uri;
	private $siteId;
	private $pageId;
	private $parameter;
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setLang($lang) {
		$this->lang = $lang;
	}
	
	public function setUri($uri) {
		$this->uri = $uri;
	}
	
	public function getUri() {
		return $this->uri;
	}
	
	public function setSiteId($siteId) {
		$this->siteId = $siteId;
	}
	
	public function setPageId($pageId) {
		$this->pageId = $pageId;
	}
	
	public function getPageId() {
		return $this->pageId;
	}
	
	public function setParameter($parameter) {
		$this->parameter = $parameter;
	}
	
	public function getParameter() {
		return $this->parameter;
	}
}
?>