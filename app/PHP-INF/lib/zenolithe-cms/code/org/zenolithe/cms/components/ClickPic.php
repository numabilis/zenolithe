<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

require daf_file('zenolithe/cms/components/clickpics.daf');

class ClickPic extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		$localizable = false;

		$model->set('ckp_picture_url', '');
		$model->set('ckp_link_url', '');

		if($this->parameter) {
			$attributes = explode(';', $this->parameter);
			$localizable = ($attributes[0] == 't');
			$model->set('ckp_picture_url', $attributes[1]);
			$model->set('ckp_link_url', $attributes[2]);
		}
		if($localizable) {
			$clickpic = select_clickpic($this->id, $lang);
			$model->set('ckp_picture_url', $clickpic['ckp_picture_url']);
			$model->set('ckp_link_url', $clickpic['ckp_link_url']);
		}

		return $model;
	}

	public function viewName() {
		return 'components/clickpic/view';
	}
}
?>
