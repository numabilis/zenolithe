<?php
namespace org\zenolithe\cms\articles;

Trait ArticlesDaoTrait {
	protected function build($articleArray) {
		$article = null;
		
		if($articleArray) {
			$article = new Article();
			$article->setId($articleArray['art_id']);
			$article->setTitle($articleArray['art_title']);
			$article->setContent($articleArray['art_content']);
			$article->setType($articleArray['art_type']);
			$article->setPageId($articleArray['art_page_id']);
		}
		
		return $article;
	}
	
	public function getByPageId($pageId) {
		$sql = 'SELECT * FROM cms_articles WHERE art_page_id = '.$this->quoteSmart($pageId);
    $a = $this->database->queryToArray($sql);
		return $this->build(array_pop($a));
	}
}
?>