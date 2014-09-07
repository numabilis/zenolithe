<?php
namespace org\zenolithe\cms\articles;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;

class ArticleViewController implements IController {
	private $articlesDao;
	
	public function setArticlesDao($articlesDao) {
		$this->articlesDao = $articlesDao;
	}
	
	public function getTranslatedIndiceUrlPart($lang) {
		return '';
	}

	public function handleRequest(Request $request) {
		$page = $request->getAttribute('page');
		$article = $this->articlesDao->getByPageId($page->getId());
		$page->set('article', $article);
		$page->setViewName('article');
		
		return $page;
	}
}
?>
