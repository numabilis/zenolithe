<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

require daf_file('zenolithe/cms/components/google-adwords.daf');

class GoogleAdWords extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();

		$model->set('show', false);
		if($request->getAttribute('formState') && ($request->getAttribute('formState') == FORM_STATE_SUCCESS)) {
			$gaw = select_gaw($request->getAttribute('page')->id);
			if($gaw) {
				$model->set('show', true);
				$model->set('label', $gaw['gaw_parameter']);
			}
		}

		return $model;
	}

	public function viewName() {
		return 'components/google-adwords-view';
	}
}
?>
