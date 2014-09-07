<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

require daf_file('zenolithe/cms/components/google-analytics.daf');

class GoogleAdSenseComponent extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		 
		$parameters = explode('/', $this->parameter);
		$model->set('client', $parameters[0]);
		$model->set('slot', $parameters[1]);
		 
		return $model;
	}

	public function viewName() {
		return 'components/google-adsense/view';
	}
}
?>
