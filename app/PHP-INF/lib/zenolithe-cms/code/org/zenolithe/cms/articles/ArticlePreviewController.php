<?php
namespace org\zenolithe\cms\articles;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\cms\page\PageModel;

class ArticlePreviewController implements IController {
	public function getTranslatedIndiceUrlPart($lang) {
		return '';
	}

	public function handleRequest(Request $request) {
		$page = new PageModel();
		$page->setViewName('article');
		
		$previewModel = $request->getAttribute('preview-model');
		$article = new Article();
		$article->setTitle($previewModel['article_title']);
		$article->setContent($previewModel['article_content']);
		$page->set('article', $article);

		return $page;
	}
}
?>
