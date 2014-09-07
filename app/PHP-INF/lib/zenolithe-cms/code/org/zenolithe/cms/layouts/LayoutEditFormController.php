<?php
namespace org\zenolithe\cms\layouts;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\forms\SimpleFormModel;
use org\zenolithe\kernel\mvc\forms\SimpleFormController;
use org\zenolithe\kernel\mvc\forms\IFormModel;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/components-admin.daf');
require daf_file('zenolithe/cms/layouts-admin.daf');
require daf_file('zenolithe/cms/contexts-admin.daf');
require daf_file('zenolithe/cms/webpage-serving.daf');

class LayoutEditFormController extends SimpleFormController {
	public $view;
	private $templatesPath;
	
	public function setTemplatesPath($templatesPath) {
		$this->templatesPath = $templatesPath;
	}
	
	public function formBackingModel(Request $request) {
		$model = new SimpleFormModel();

		$model->setField('action', '');
		$model->setField('componentId', 0);
		$model->setField('newComponentId', 0);
		$model->setField('componentOrder', 0);
		$model->setField('zoneName', '');
		$model->setField('classes', array());
		$model->setField('configurable', false);

		$domain = $request->getSession()->getAttribute('edited-domain');
		$model->setAttribute('edited_domain', $domain);
		$model->setAttribute('site_id', $domain['dom_site_id']);
		$cpt = select_component_by_type($domain['dom_site_id'], 'template');
		$templates = explode('#', $cpt['cpt_parameter']);
		$model->setAttribute('template_name', $templates[0]);
		require $this->templatesPath.$templates[0].'.conf.php';
		$model->setAttribute('template_classes', $template['component-classes']);
		$model->setAttribute('components', select_components_by_site_id_and_role($domain['dom_site_id'], 'view-component'));

		$layoutComponents = array();
		$id = $request->getParameter('id');
		if($id) {
			$model->setAttribute('layout_id', $id);
			$layout = select_layout_by_id($id);
			$model->setField('layout_name', $layout['lay_name']);
			$model->setAttribute('layout_type', $layout['lay_type']);
			$model->setAttribute('template_zones', $template['zones'][$layout['lay_type']]);
			$components = select_components_by_context_id($id);
			foreach($components as $component) {
				if(!$component['ctx_class']) {
					$component['ctx_class'] = 'standard';
				}
				$layoutComponents[$component['ctx_zone']][] = $component;
			}
		} else {
			$model->setAttribute('layout_type', $request->getParameter('type'));
			$model->setAttribute('layout_id', 0);
			$model->setField('layout_name', '');
		}
		$model->setField('layout_components', $layoutComponents);

		return $model;
	}

	protected function validate(IFormModel $model) {
		if(($model->getField('action') == 'styles') && strlen(trim($model->getField('layout_name'))) == 0) {
			$model->rejectValue('layout_name','Nom invalide');
		}
	}

	public function doSubmitAction(IFormModel $model) {
		switch($model->getField('action')) {
			case 'add':
				insert_context($model->getAttribute('layout_id'), $model->getField('componentId'), $model->getField('zoneName'), '');
				break;
			case 'exchange':
				update_component_context($model->getAttribute('layout_id'), $model->getField('componentId'), $model->getField('zoneName'), $model->getField('componentOrder'), $model->getField('newComponentId'));
				break;
			case 'remove':
				delete_context($model->getAttribute('layout_id'), $model->getField('componentId'), $model->getField('zoneName'), $model->getField('componentOrder'));
				decrease_contexts_order($model->getAttribute('layout_id'), $model->getField('zoneName'), $model->getField('componentOrder'));
				break;
			case 'down':
				$maxOrder = select_max_context_order($model->getAttribute('layout_id'), $model->getField('zoneName'));
				if($model->getField('componentOrder') < $maxOrder) {
					decrease_context_order($model->getAttribute('layout_id'), $model->getField('zoneName'), $model->getField('componentOrder')+1);
					increase_context_component_order($model->getAttribute('layout_id'), $model->getField('componentId'), $model->getField('zoneName'));
				}
				break;
			case 'up':
				if($model->getField('componentOrder') > 0) {
					increase_context_order($model->getAttribute('layout_id'), $model->getField('zoneName'), $model->getField('componentOrder')-1);
					decrease_context_component_order($model->getAttribute('layout_id'), $model->getField('componentId'), $model->getField('zoneName'));
				}
				break;
			case 'styles':
				if($model->getAttribute('layout_id')) {
					update_layout($model->getAttribute('layout_id'), $model->getField('layout_name'));
				} else {
					$model->setAttribute('layout_id', insert_layout($model->getField('layout_name'), $model->getAttribute('layout_type'), $model->getAttribute('site_id')));
				}
				foreach($model->getField('classes') as $key => $class) {
					list($componentId, $zone, $order) = explode(',', $key);
					update_class_context($model->getAttribute('layout_id'), $componentId, $zone, $order, $class);
				}
				break;
		}
		$key = 'select_components_by_context_id/'.$model->getAttribute('layout_id');
		apc_delete($key);
		$this->redirect('?id='.$model->getAttribute('layout_id'));
	}
}
?>
