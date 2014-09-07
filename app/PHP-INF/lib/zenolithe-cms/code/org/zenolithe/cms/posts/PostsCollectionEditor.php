<?php
namespace org\zenolithe\cms\posts;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\pages\editors\PageEditor;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/pages/articles-serving.daf');
require daf_file('zenolithe/cms/pages/articles-admin.daf');

class PostsCollectionEditor extends PageEditor {
	public function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();

		return $model;
	}

	public function validateLocalizationModel(IFormModel $model) {
	}

	public function doLocalizationSubmitAction(IFormModel $model) {
	}

	public function isConfigurable() {
		return true;
	}

	public function getConfigurationBackingModel() {
		$model = new SimpleFormModel();
		
		$categoryId = $this->getProperties();
		$model->set('categoryId', $categoryId);
		// Retrieve category
		// category name
		
		return $model;
	}

	public function getConfigurationViewName() {
	}

	public function validateConfigurationModel(IFormModel $model) {
		// Check that there is no other category with the same name
	}

	public function doConfigurationSubmitAction(IFormModel $model) {
		// Create/update category
	}

	public function isConfigurationUpdatedProperties() {
		return false;
	}
	
	public function getUpdatedProperties(IFormModel $model) {
		return '';
	}
}
?>
