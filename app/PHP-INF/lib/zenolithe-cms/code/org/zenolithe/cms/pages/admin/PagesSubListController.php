<?php
namespace org\zenolithe\cms\pages\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/pages-admin.daf');

class PagesSubListController implements IController {
	protected $view ;
	
	public function setView($view) {
		$this->view = $view;
	}
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();

		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->set('edited_domain', $domain);
		$model->set('supported_languages', explode(',', $domain['dom_languages']));
		$pages = select_all_pages_by_parent($domain['dom_site_id'],  $request->getParameter('groupId'));
		$p = array();
		foreach($pages as $page) {
			$p[$page['pge_group']][$page['pge_lang']] = $page;
		}
		foreach($p as $group => $pages) {
			$p[$group]['children'] = select_all_pages_by_parent($domain['dom_site_id'],  $group);
		}
		$model->set('pages', $p);
		$model->set('level', $request->getParameter('level'));
	  
		$model->setViewName($this->view);

		return $model;
	}
}
?>