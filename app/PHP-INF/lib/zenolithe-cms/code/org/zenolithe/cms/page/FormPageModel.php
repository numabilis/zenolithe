<?php
namespace org\zenolithe\cms\page;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;

class FormPageModel extends SimpleFormModel implements IPageModel {
	private $metaScriptLinks = array();
	private $metaTitle;
	private $metaDescription;
	private $canonical;
	private $nextPage;
	private $previousPage;
	private $content = array();
	private $isHome = false;
	
	public function addMetaScriptLink($scriptLink) {
		$this->metaScriptLinks[] = $scriptLink;
	}
	
	public function getMetaTitle() {
		return $this->metaTitle;
	}
	
	public function getMetaDescription() {
		return $this->metaDescription;
	}
	
	public function getCanonical() {
		return $this->canonical;
	}
	
	public function setCanonical($canonical) {
		$this->canonical = $canonical;
	}
	
	public function setNextPage($nextPage) {
		$this->nextPage = $nextPage;
	}
	
	public function setPreviousPage($previousPage) {
		$this->previousPage = $previousPage;
	}
	
	public function addContent($zone, $content) {
		$this->content[$zone][] = $content;
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