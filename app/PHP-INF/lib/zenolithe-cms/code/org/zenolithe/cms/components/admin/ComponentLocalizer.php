<?php
namespace org\zenolithe\cms\components\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/webpage-serving.daf');
require daf_file('zenolithe/cms/contexts-admin.daf');
require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/components-admin.daf');

class ComponentLocalizer extends SimpleFormController {
	private $componentsPath;
	
	public function setComponentsPath($componentsPath) {
		$this->componentsPath = $componentsPath;
	}
	
	protected function formBackingModel(Request $request) {
	    $model = new SimpleFormModel();
	    
	    $domain = $request->getSession()->getAttribute('edited-domain');
	    $lang = $request->getParameter('lang');
	    if(!$lang) {
	        $lang = $request->getLocale();
	    }
	    $cpt = select_component_by_id($request->getParameter('id'));
	    require $this->componentsPath.$cpt['cpt_type'].'.conf.php';
	    $editor = new $component['editor']();
	    if(isset($component['editor-configuration'])) {
	        $editor->configure($component['editor-configuration']);
	    }
	    $editor->setId($cpt['cpt_id']);
	    $editor->setSiteId($cpt['cpt_site_id']);
	    $editor->setName($cpt['cpt_name']);
	    $editor->setType($cpt['cpt_type']);
	    $editor->setClass($cpt['cpt_class']);
	    $editor->setSubstituteId($cpt['cpt_substitute_id']);
	    $editor->setSupportedLangs($cpt['cpt_supported_langs']);
	    $editor->setParam($cpt['cpt_parameter']);
	    $editor->setLang($lang);
	    if($editor->isLocalizable()) {
        $model = $editor->getLocalizationBackingModel($lang);
        $model->setAttribute('component-localization-view', $editor->getLocalizationViewName($lang));
    		$model->setAttribute('cpt_editor', $editor);
    		$model->setAttribute('cpt_id', $cpt['cpt_id']);
    		$model->setField('cpt_name', $cpt['cpt_name']);
    		$model->setAttribute('cpt_lang', $lang);
    		$model->setAttribute('supported_langs', explode(',', $domain['dom_languages']));
	    } else {
	       $request->redirect('configure.php?id='.$request->getParameter('id'));
	    }
		$model->setAttribute('cpt_localizable', true);
		$model->setAttribute('edited_domain', $domain);
		
		return $model;
	}
	
	protected function validate(IFormModel $model) {
	    $model->getAttribute('cpt_editor')->validateLocalizationModel($model);
	}
	
	protected function doSubmitAction(IFormModel $model) {
    $editor = $model->getAttribute('cpt_editor');
	  $editor->doLocalizationSubmitAction($model);
	  if($editor->getSupportedLangs() != '') {
		    $langs = array();
    		$tmpLangs = explode('/', $editor->getSupportedLangs());
    		foreach($tmpLangs as $lang) {
    		    if($lang != '') {
    		        $langs[] = $lang;
    		    }
    		}
    		$found = false;
    		foreach($langs as $lang) {
    		    if($model->getAttribute('cpt_lang') == $lang) {
    		        $found = true;
    		        break;
    		    }
    		}
    		if(!$found && $model->getAttribute('cpt_lang')) {
    		    $langs[] = $model->getAttribute('cpt_lang');
    		}
    		$supportedLangs = '/' . implode('/', $langs) . '/';
		} else if($model->getAttribute('cpt_lang')) {
		    $supportedLangs = '/' . $model->getAttribute('cpt_lang') . '/';
		} else {
			$supportedLangs = '';
		}
		update_component_parameter_and_langs($model->getAttribute('cpt_id'), $editor->getParameter(), $supportedLangs);
//		apc_delete('select_component_by_id/'.$model->getAttribute('cpt_id'));
		$this->redirect('edit.php?id='.$model->getAttribute('cpt_id').'&lang='.$model->getAttribute('cpt_lang'));
	}
}