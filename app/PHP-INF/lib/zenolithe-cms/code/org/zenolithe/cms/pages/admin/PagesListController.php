<?php
namespace org\zenolithe\cms\pages\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/pages-admin.daf');

class PagesListController implements IController {
	protected $view ;
	private $zenolitheRoot;
	private $pagesPath;
	
	public function setZenolitheRoot($zenolitheRoot) {
		$this->zenolitheRoot = $zenolitheRoot;
	}
	
	public function setPagesPath($pagesPath) {
		$this->pagesPath = $pagesPath;
	}
		
	public function setView($view) {
		$this->view = $view;
	}
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->set('edited_domain', $domain);
		$model->set('domain_url', $domain['dom_base']);
		$model->set('supported_languages', explode(',', $domain['dom_languages']));
		$pages = select_pages_by_uri($domain['dom_site_id'], '');
		$p = array();
		foreach($pages as $page) {
			$p[$page['pge_group']][$page['pge_lang']] = $page;
		}
		$model->set('root_pages', $p);
		$pages = select_all_pages_by_parent($domain['dom_site_id'], 0);
		$p = array();
		foreach($pages as $page) {
			$p[$page['pge_group']][$page['pge_lang']] = $page;
		}
		$model->set('pages', $p);
		
		$rootPath = $this->zenolitheRoot.'lib/';
		if(is_dir($rootPath)) {
			$entries = scandir($rootPath);
			if($entries) {
				foreach($entries as $entry) {
					if(($entry != '.') && ($entry != '..') && is_dir($rootPath.$entry)) {
						$folderPath = $rootPath.$entry.'/'.$this->pagesPath;
						if(is_dir($folderPath)) {
							if($folder = opendir($folderPath)) {
								while(($file = readdir($folder)) !== false) {
									if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
										continue;
									}
									require $folderPath.$file;
									$pagesTypes[] = $page['type'];
								}
							}
						}
					}
				}
			}
		}
		$model->set('pages_types', $pagesTypes);
		$model->set('level', 0);

		$model->setViewName($this->view);

		return $model;
	}
}
?>