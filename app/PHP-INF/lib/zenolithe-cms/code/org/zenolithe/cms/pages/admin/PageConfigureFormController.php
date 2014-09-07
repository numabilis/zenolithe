<?php
namespace org\zenolithe\cms\pages\admin;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/pages-admin.daf');
require daf_file('zenolithe/cms/layouts-admin.daf');

class PageConfigureFormController extends SimpleFormController {
	private $pagesPath;
	
	public function setPagesPath($pagesPath) {
		$this->pagesPath = $pagesPath;
	}
	
	protected function formBackingModel(Request $request) {
		$model = array();

		$domain = $request->getSession()->getAttribute('edited-domain');
		$group = $request->getParameter('group');
		$translations = select_all_pages_by_group($domain['dom_site_id'], $group);
		$pageType = $translations[0]['pge_type'];
		$ctrlProperties = $translations[0]['pge_ctrl_properties'];
		require $this->pagesPath.$pageType.'.conf.php';
		$editor = new $page['editor']();
		if(isset($page['editor-configuration'])) {
			$editor->configure($page['editor-configuration']);
		}
		$editor->setProperties($ctrlProperties);
		$model = $editor->getConfigurationBackingModel();
		if(!$model) {
			$model = array();
		}
		$model->setAttribute('editor', $editor);
		$modelTranslations = array();
		foreach($translations as $translation) {
			$modelTranslations[$translation['pge_lang']] = $translation;
		}
		$model->setAttribute('translations', $modelTranslations);
		$model->setAttribute('supported_languages', explode(',', $domain['dom_languages']));
		$model->setAttribute('page_configuration_view', $editor->getConfigurationViewName());
		$model->setAttribute('page_group', $group);
		$model->setField('page_layout_id', $translations[0]['pge_context_id']);
		$model->setAttribute('layouts', select_all_layouts($domain['dom_site_id']));
		$model->setAttribute('edited_domain', $domain);

		return $model;
	}

	protected function validate(IFormModel $model) {
		$model->getAttribute('editor')->validateConfigurationModel($model);
	}
	protected function doSubmitAction(IFormModel $model) {
		$editor = $model->getAttribute('editor');
		$editor->doConfigurationSubmitAction($model);
		if($editor->isConfigurationUpdatedProperties()) {
			update_pages($model->getAttribute('page_group'), $editor->getUpdatedProperties($model), $model->getField('page_layout_id'));
		} else {
			update_pages_context($model->getAttribute('page_group'), $model->getField('page_layout_id'));
		}
	}
}
?>