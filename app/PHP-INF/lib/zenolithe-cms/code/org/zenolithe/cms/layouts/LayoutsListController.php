<?php
namespace org\zenolithe\cms\layouts;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/components-admin.daf');
require daf_file('zenolithe/cms/layouts-admin.daf');

class LayoutsListController implements IController {
	private $view ;
	private $templatesPath;
	
	public function setTemplatesPath($templatesPath) {
		$this->templatesPath = $templatesPath;
	}
	
	public function setView($view) {
		$this->view = $view;
	}
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->set('edited_domain', $domain);
		$cpt = select_component_by_type($domain['dom_site_id'], 'template');
		$templates = explode('#', $cpt['cpt_parameter']);
		$model->set('template_name', $templates[0]);
		require $this->templatesPath.$templates[0].'.conf.php';
		$model->set('template', $template);
    $model->set('layouts', select_all_layouts($domain['dom_site_id']));
		
		$model->setViewName($this->view);
		
		return $model;
	}
}
?>