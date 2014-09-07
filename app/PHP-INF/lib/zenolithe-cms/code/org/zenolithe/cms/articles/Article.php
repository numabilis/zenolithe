<?php
namespace org\zenolithe\cms\articles;

class Article {
	private $id;
	private $title;
	private $content;
	private $type;
	private $pageId;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setContent($content) {
		$this->content = $content;
	}

	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function getPageId() {
		return $this->pageId;
	}
	
	public function setPageId($pageId) {
		$this->pageId = $pageId;
	}
}
?>