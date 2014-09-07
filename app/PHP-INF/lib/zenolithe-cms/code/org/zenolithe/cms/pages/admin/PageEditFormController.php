<?php
namespace org\zenolithe\cms\pages\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\Validator;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\lang\DatetimeHelper;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/pages-admin.daf');
require daf_file('zenolithe/cms/webpage-serving.daf');

class PageEditFormController extends SimpleFormController {
	private $pagesPath;
	private $componentsPath;
	
	public function setComponentsPath($componentsPath) {
		$this->componentsPath = $componentsPath;
	}
	
	public function setPagesPath($pagesPath) {
		$this->pagesPath = $pagesPath;
	}
	
	protected function formBackingModel(Request $request) {
		$model = new SimpleFormModel();
		$model->setAttribute('tmp_file', '');
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		$id = $request->getParameter('pageId');
		if($id) {
			$pge = select_page_by_id($id);
			require $this->pagesPath.$pge['pge_type'].'.conf.php';
			$editor = new $page['editor']();
			$editor->setControllerClass($page['class']);
			$editor->setPageId($pge['pge_id']);
			$editor->setProperties($pge['pge_ctrl_properties']);
			$model = $editor->getLocalizationBackingModel($pge['pge_lang']);
			$model->setAttribute('components_localizers', array());
			if(isset($page['preview-class'])) {
				$editor->setPreviewControllerClass($page['preview-class']);
				$model->setAttribute('preview_allowed', true);
			} else {
				$model->setAttribute('preview_allowed', false);
			}
			$model->setAttribute('page_id', $id);
			$model->setAttribute('page_context_id', $pge['pge_context_id']);
			$model->setAttribute('page_lang', $pge['pge_lang']);
			$model->setAttribute('page_type', $pge['pge_type']);
			$model->setAttribute('page_parent_group', $pge['pge_parent_group']);
			$parents = array();
			$parent_group = $pge['pge_parent_group'];
			while($parent_group != 0) {
				$parent = select_page_by_parent_group_and_lang($domain['dom_site_id'], $parent_group, $pge['pge_lang']);
				$parents[] = $parent;
				$parent_group = $parent['pge_parent_group'];
			}
			$model->setField('page_uri', $pge['pge_uri']);
			$model->setField('page_status', $pge['pge_status']);
			$model->setField('page_title', $pge['pge_title']);
			$model->setField('page_short_title', $pge['pge_short_title']);
			$model->setField('page_menu', $pge['pge_menu']);
			$model->setField('page_meta_title', $pge['pge_meta_title']);
			$model->setField('page_publish_date', DatetimeHelper::iso2format($pge['pge_publish_date'], 'd/m/Y H:i'));
			$model->setField('page_description', $pge['pge_description']);
			$model->setField('page_keywords', $pge['pge_keywords']);
			if(strpos($pge['pge_robots'], 'noindex') !== FALSE) {
				$model->setField('page_robots_noindex', 1);
			} else {
				$model->setField('page_robots_noindex', 0);
			}
			if(strpos($pge['pge_robots'], 'nofollow') !== FALSE) {
				$model->setField('page_robots_nofollow', 1);
			} else {
				$model->setField('page_robots_nofollow', 0);
			}
			$modelTranslations = array();
			$translations = select_all_pages_by_group($domain['dom_site_id'], $pge['pge_group']);
			foreach($translations as $translation) {
				$modelTranslations[$translation['pge_lang']] = $translation;
			}
			$model->setAttribute('translations', $modelTranslations);
			$model->setAttribute('page_group', $pge['pge_group']);
			$model->setAttribute('page_order', $pge['pge_order']);
			$components = select_components_by_context_id($pge['pge_context_id']);
			$componentsLocalizers = array();
			foreach($components as $cpt) {
				$component = array();
				require $this->componentsPath.$cpt['cpt_type'].'.conf.php';
				if(isset($component['editor-page-localization'])) {
					$componentEditor = new $component['editor-page-localization']();
					$componentEditor->setPageId($pge['pge_id']);
					$componentsLocalizers[$cpt['cpt_type']]['editor'] = $componentEditor;
					$cptModel = $componentEditor->getLocalizationBackingModel($pge['pge_lang']);
					if($cptModel) {
						// TODO : refactor for decorator DP
						$model = array_merge($model, $cptModel);
					}
					$componentsLocalizers[$cpt['cpt_type']]['view'] = $componentEditor->getLocalizationViewName($pge['pge_lang']);
				}
			}
			$model->setAttribute('components_localizers', $componentsLocalizers);
		} else {
			if($request->getParameter('pageType') != '') {
				require $this->pagesPath.$request->getParameter('pageType').'.conf.php';
				$editor = new $page['editor']();
				$editor->setControllerClass($page['class']);
				$model = $editor->getLocalizationBackingModel($request->getLocale());
				$model->setAttribute('components_localizers', array());
				if(isset($page['preview-class'])) {
					$editor->setPreviewControllerClass($page['preview-class']);
					$model->setAttribute('preview_allowed', true);
				} else {
					$model->setAttribute('preview_allowed', false);
				}
				$model->setAttribute('page_lang', $request->getLocale());
				$model->setAttribute('page_type', $request->getParameter('pageType'));
				$model->setAttribute('page_parent_group', $request->getParameter('parentGroup'));
				$parents = array();
				$parent_group = $request->getParameter('parentGroup');
				$model->setAttribute('page_context_id', 0);
				while($parent_group != 0) {
					$parent = select_page_by_parent_group_and_lang($domain['dom_site_id'], $parent_group, $request->getLocale());
					if($model->getAttribute('page_context_id') == 0) {
						$model->setAttribute('page_context_id', $parent['pge_context_id']);
					}
					$parents[] = $parent;
					$parent_group = $parent['pge_parent_group'];
				}
				$model->setField('page_uri', '');
				while($parent = array_pop($parents)) {
					if($parent['pge_uri_part']) {
						$model->setField('page_uri', $model->getField('page_uri').$parent['pge_uri_part'].'/');
					}
				}
				$model->setAttribute('page_group', 0);
				$model->setAttribute('translations', array());
				$model->setAttribute('page_order', select_max_page_order($domain['dom_site_id'], $model->getAttribute('page_parent_group')) + 1);
			} else {
				$translations = select_all_pages_by_group($domain['dom_site_id'], $request->getParameter('group'));
				require $this->pagesPath.$translations[0]['pge_type'].'.conf.php';
				$editor = new $page['editor']();
				$editor->setControllerClass($page['class']);
				$model = $editor->getLocalizationBackingModel($request->getParameter('lang'));
				$model->setAttribute('components_localizers', array());
				if(isset($page['preview-class'])) {
					$editor->setPreviewControllerClass($page['preview-class']);
					$model->setAttribute('preview_allowed', true);
				} else {
					$model->setAttribute('preview_allowed', false);
				}
				$model->setField('page_uri', '');
				$model->setAttribute('page_lang', $request->getParameter('lang'));
				$model->setAttribute('page_type', $translations[0]['pge_type']);
				$model->setAttribute('page_parent_group', $translations[0]['pge_parent_group']);
				$parents = array();
				$parent_group = $model->getAttribute('page_parent_group');
				while($parent_group != 0) {
					$parent = select_page_by_parent_group_and_lang($domain['dom_site_id'], $parent_group, $model->getAttribute('page_lang'));
					$parents[] = $parent;
					$parent_group = $parent['pge_parent_group'];
				}
				while($parent = array_pop($parents)) {
					if($parent['pge_uri_part']) {
						$model->setField('page_uri',  $model->getField('page_uri').$parent['pge_uri_part'].'/');
					}
				}
				$model->setAttribute('page_group', $translations[0]['pge_group']);
				$model->setAttribute('page_order', $translations[0]['pge_order']);
				$model->setAttribute('page_context_id', $translations[0]['pge_context_id']);
				$modelTranslations = array();
				foreach($translations as $translation) {
					$modelTranslations[$translation['pge_lang']] = $translation;
				}
				$model->setAttribute('translations', $modelTranslations);
			}
			$model->setAttribute('page_id', 0);
			$model->setField('page_status', PAGE_STATUS_DRAFT);
			$model->setField('page_title', '');
			$model->setField('page_short_title', '');
			$model->setField('page_menu', false);
			$model->setField('page_meta_title', '');
			$model->setField('page_publish_date', date('d/m/Y H:i'));
			$model->setField('page_description', '');
			$model->setField('page_keywords', '');
			$model->setField('page_robots_noindex', 0);
			$model->setField('page_robots_nofollow', 0);
		}
		if(isset($page['editor-localization-view'])) {
			$editor->setLocalizationViewName($page['editor-localization-view']);
		}
		$model->setAttribute('editor', $editor);
		$model->setAttribute('configurable', $editor->isConfigurable());
		$model->setAttribute('domain_url', $domain['dom_base']);
		$model->setAttribute('supported_languages', explode(',', $domain['dom_languages']));
		$model->setAttribute('page_localization_view', $editor->getLocalizationViewName($model->getAttribute('page_lang')));
		$model->setAttribute('site_id', $domain['dom_site_id']);
		$model->setAttribute('edited_domain', $domain);
		$model->setField('save', true);
		$model->setField('preview', true);
		$model->setAttribute('uri', $model->getField('page_uri'));
		
		return $model;
	}

	protected function validate(IFormModel $model) {
		if(!Validator::isValid($model->getAttribute('domain_url').$model->getAttribute('page_lang').'/'.$model->getField('page_uri'), URL)) {
			$model->rejectValue('page_uri','URL invalide');
		} else {
			$page = select_page_by_uri_and_lang($model->getAttribute('domain_url'), $model->getField('page_uri'), $model->getAttribute('page_lang'));
			if($page && ($page['pge_id'] != $model->getAttribute('page_id'))) {
				$model->rejectValue('page_uri', 'URL already exists');
			}
		}
		$model->getAttribute('editor')->validateLocalizationModel($model);
		foreach($model->getAttribute('components_localizers') as $cpt) {
			$cpt['editor']->validateLocalizationModel($model);
		}
		if((!$model->hasError()) && $model->getField('preview')) {
			$previewData = array();
			$domain = $model->getAttribute('edited_domain');
			$previewData['page']['dom_id'] = $domain['dom_id'];
			$previewData['page']['dom_site_id'] = $domain['dom_site_id'];
			$previewData['page']['dom_mnem'] = $domain['dom_mnem'];
			$previewData['page']['dom_base'] = $domain['dom_base'];
			$previewData['page']['dom_languages'] = $domain['dom_languages'];
			$previewData['page']['pge_id'] = $model->getAttribute('page_id');
			$previewData['page']['pge_site_id'] = $model->getAttribute('site_id');
			$previewData['page']['pge_lang'] = $model->getAttribute('page_lang');
			$previewData['page']['pge_uri'] = $model->getField('page_uri');
			if((strlen(trim($model->getField('page_uri'))) != 0) && (strrpos($model->getField('page_uri'), '/') != strlen($model->getField('page_uri'))-1)) {
				$model->setField('page_uri', $model->getField('page_uri').'/');
			}
			if(strrpos($model->getField('page_uri'), '/', -2) !== FALSE) {
				$pageUriPart = substr($model->getField('page_uri'), strrpos($model->getField('page_uri'), '/', -2)+1);
				$pageUriPart = substr($pageUriPart, 0, strlen($pageUriPart)-1);
			} else if(strlen(trim($model->getField('page_uri'))) != 0) {
				$pageUriPart = substr($model->getField('page_uri'), 0, strlen($model->getField('page_uri'))-1);
			} else {
				$pageUriPart = '';
			}
			$previewData['page']['pge_uri_part'] = $pageUriPart;
			$previewData['page']['pge_ctrl_properties'] = $model->getAttribute('editor')->getUpdatedProperties($model);
			$previewData['page']['pge_context_id'] = $model->getAttribute('page_context_id');
			$previewData['page']['pge_group'] = $model->getAttribute('page_group');
			$previewData['page']['pge_parent_group'] = $model->getAttribute('page_parent_group');
			$previewData['page']['pge_title'] = $model->getField('page_title');
			$previewData['page']['pge_order'] = $model->getAttribute('page_order');
			$previewData['page']['pge_status'] = $model->getField('page_status');
			$previewData['page']['pge_publish_date'] = $model->getField('page_publish_date');
			$previewData['page']['pge_description'] = $model->getField('page_description');
			$previewData['page']['pge_keywords'] = $model->getField('page_keywords');
			$previewData['page']['page_robots_noindex'] = $model->getField('page_robots_noindex');
			$previewData['page']['page_robots_nofollow'] = $model->getField('page_robots_nofollow');
			$previewData['page']['pge_controller'] = $model->getAttribute('editor')->getPreviewControllerClass();
			$previewData['page']['pge_type'] = $model->getAttribute('page_type');
			$previewData['page']['pge_meta_title'] = $model->getField('page_meta_title');
			$previewData['page']['pge_short_title'] = $model->getField('page_short_title');
			$previewData['page']['pge_menu'] = $model->getField('page_menu');
			$previewData['model'] = $model;
			$sessionData[$model->getAttribute('domain_url').$model->getAttribute('page_lang').'/'.$model->getField('page_uri')] = $previewData;
			$tmpfname = tempnam('/tmp', 'zenolithe_cms_preview_');
			$file = fopen($tmpfname, 'w');
			fwrite($file, serialize($previewData));
			fclose($file);
			if($model->getAttribute('tmp_file')) {
				unlink($model->getAttribute('tmp_file'));
				$model->setAttribute('tmp_file', $tmpfname);
			}
			$model->rejectValue('preview', $model->getAttribute('domain_url').$model->getAttribute('page_lang').'/'.$model->getField('page_uri').'?preview='.$tmpfname);
		}
	}

	protected function doSubmitAction(IFormModel $model) {
		$editor = $model->getAttribute('editor');
		$robots = '';
		if($model->getField('page_robots_noindex')) {
			$robots = 'noindex';
		}
		if($model->getField('page_robots_nofollow')) {
			if($robots) {
				$robots .= ', nofollow';
			} else {
				$robots = 'nofollow';
			}
		}
		if($model->getField('page_menu')) {
			$model->setField('page_menu', 't');
		} else {
			$model->setField('page_menu', 'f');
		}
		if((strlen(trim($model->getField('page_uri'))) != 0) && (strrpos($model->getField('page_uri'), '/') != strlen($model->getField('page_uri'))-1)) {
			$model->setField('page_uri', $model->getField('page_uri').'/');
		}
		if((strlen($model->getField('page_uri')) > 2) && (strrpos($model->getField('page_uri'), '/', -2) !== false)) {
			$pageUriPart = substr($model->getField('page_uri'), strrpos($model->getField('page_uri'), '/', -2)+1);
			$pageUriPart = substr($pageUriPart, 0, strlen($pageUriPart)-1);
		} else if(strlen(trim($model->getField('page_uri'))) != 0) {
			$pageUriPart = substr($model->getField('page_uri'), 0, strlen($model->getField('page_uri'))-1);
		} else {
			$pageUriPart = '';
		}
		if($model->getAttribute('page_id')) {
			update_page($model->getAttribute('page_id'), $model->getField('page_uri'), $pageUriPart, $editor->getUpdatedProperties($model),
			$model->getField('page_title'), $model->getField('page_short_title'), $model->getField('page_menu'), $model->getField('page_status'),
			date('Y-m-d H:i:s', DatetimeHelper::frdatetime2tstp($model->getField('page_publish_date'))), $model->getField('page_description'),
			$model->getField('page_keywords'), $model->getField('page_meta_title'), $robots);
		} else {
			if($model->getAttribute('page_group') == 0) {
				$model->setAttribute('page_group', get_next_group());
			}
			$model->setAttribute('page_id', insert_page($model->getAttribute('site_id'), $model->getAttribute('page_lang'), $model->getField('page_uri'), $pageUriPart,
			$model->getAttribute('page_context_id'), $model->getAttribute('page_group'), $model->getAttribute('page_parent_group'), $model->getField('page_title'), $model->getField('page_short_title'), $model->getField('page_menu'),
			$model->getAttribute('page_order'), $model->getField('page_status'), date('Y-m-d H:i:s', DatetimeHelper::frdatetime2tstp($model->getField('page_publish_date'))), $model->getField('page_description'),
			$model->getField('page_keywords'), $model->getField('page_meta_title'), $robots, $editor->getControllerClass(), $model->getAttribute('page_type'), $editor->getUpdatedProperties($model)));
		}
		$editor->setPageId($model->getAttribute('page_id'));
		$editor->doLocalizationSubmitAction($model);
		$this->redirect('?pageId='.$model->getAttribute('page_id'));
		if($model->getAttribute('tmp_file')) {
			unlink($model->getAttribute('tmp_file'));
			$model->setAttribute('tmp_file', '');
		}
		foreach($model->getAttribute('components_localizers') as $cpt) {
			$cpt['editor']->doLocalizationSubmitAction($model);
		}
		
		if($model->getAttribute('uri') && ($model->getAttribute('uri') != $model->getField('page_uri'))) {
			$page = select_page_by_uri_and_lang($model->getAttribute('domain_url'), $model->getAttribute('uri'), $model->getAttribute('page_lang'));
			if(!$page) {
				if(strrpos($model->getAttribute('uri'), '/', -2) !== false) {
					$pageUriPart = substr($model->getAttribute('uri'), strrpos($model->getAttribute('uri'), '/', -2)+1);
					$pageUriPart = substr($pageUriPart, 0, strlen($pageUriPart)-1);
				} else if(strlen(trim($model->getAttribute('uri'))) != 0) {
					$pageUriPart = substr($model->getAttribute('uri'), 0, strlen($model->getAttribute('uri'))-1);
				} else {
					$pageUriPart = '';
				}
				$model->setAttribute('page_id', insert_page($model->getAttribute('site_id'), $model->getAttribute('page_lang'), $model->getAttribute('uri'), $pageUriPart, 0, 0, -1, '', '', 'f', 0, 2,
						date('Y-m-d H:i:s'), '', '', '', '', 'redirectController', 'redirect', 'url=/'.$model->getAttribute('page_lang').'/'.$model->getField('page_uri').'&code=301'));
			}
		}
	}

	private function getParentUri($uri) {
			
	}
}
