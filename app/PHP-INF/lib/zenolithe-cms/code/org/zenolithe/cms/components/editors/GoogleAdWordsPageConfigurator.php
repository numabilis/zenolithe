<?php
namespace org\zenolithe\cms\components\editors;

use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\cms\components\admin\PageComponentConfigurator;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/components/google-adwords.daf');
require daf_file('zenolithe/cms/components/google-adwords-admin.daf');

class GoogleAdWordsPageConfigurator extends PageComponentConfigurator {
	private $id;
	
	public function getLocalizationBackingModel($lang) {
		$model = new SimpleFormModel();
		
		$model->setField('gawLabel', '');
		$gaw = select_gaw($this->pageId);
		if($gaw) {
			$model->setField('gawLabel', $gaw['gaw_parameter']);
			$this->id = $gaw['gaw_id'];
		}
		
		return $model;
	}
	
	public function getLocalizationViewName($lang) {
		return 'components/google-adwords-page-localization';
	}
	
	public function validateLocalizationModel(IFormModel $model) {
	}
	
	public function doLocalizationSubmitAction(IFormModel $model) {
		if($this->id) {
			update_gaw($this->id, $this->pageId, $model->getField('gawLabel'));
		} else {
			insert_gaw($this->pageId, $model->getField('gawLabel'));
		}
	}
}
?>