<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class GoogleAnalyticsEventTracker extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		if($pageModel->get('gaq_model')) {
			$model = $pageModel->get('gaq_model');
		} else {
			$model = new SimpleModel();
		}

		return $model;
	}

	public function viewName() {
		return 'components/ga-event-tracker';
	}
}
?>
