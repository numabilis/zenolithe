<?php
namespace org\zenolithe\cms\articles;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\pages\editors\PageEditor;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/pages/articles-serving.daf');
require daf_file('zenolithe/cms/pages/articles-admin.daf');

class ArticleEditor extends PageEditor {
	public $pageType = 'page';
	
	public function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		$article = select_article_by_page_id($this->pageId);
		if($article) {
			$model->setAttribute('article_id', $article['art_id']);
			$model->setField('article_title', $article['art_title']);
			$model->setField('article_content', $article['art_content']);
		} else {
			$model->setAttribute('article_id', 0);
			$model->setField('article_title', '');
			$model->setField('article_content', '');
		}

		return $model;
	}

	public function validateLocalizationModel(IFormModel $model) {
	}

	public function doLocalizationSubmitAction(IFormModel $model) {
		$model->setField('article_content', str_replace('\\"', '"', $model->getField('article_content')));
		if($model->getAttribute('article_id')) {
			update_article($model->getAttribute('article_id'), $model->getField('article_title'), $model->getField('article_content'), $this->pageId, $this->pageType);
		} else {
			$model->setAttribute('article_id', insert_article($model->getField('article_title'), $model->getField('article_content'), $this->pageId, $this->pageType));
		}
	}

	public function isConfigurable() {
		return false;
	}

	public function getConfigurationBackingModel() {
		return null;
	}

	public function getConfigurationViewName() {
	}

	public function validateConfigurationModel(IFormModel $model) {
	}

	public function doConfigurationSubmitAction(IFormModel $model) {
	}

	public function isConfigurationUpdatedProperties() {
		return false;
	}
	
	public function getUpdatedProperties(IFormModel $model) {
		return '';
	}
}
?>
