<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

require daf_file('zenolithe/cms/components/multiclickpics.daf');

class MultiClickPic extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();

		$multiclickpic = select_multiclickpics($this->id, $lang);
		$clickPicCount = count($multiclickpic);
		for($i=0; $i < $clickPicCount; $i++) {
			$model->set('mcp_picture_url_'.$i, $multiclickpic[$i]['mcp_picture_url']);
			$model->set'mcp_link_url_'.$i, $multiclickpic[$i]['mcp_link_url']);
		}
		$model->set('mcp_count', $clickPicCount);

		return $model;
	}

	public function viewName() {
		return 'components/multiclickpic';
	}
}
?>
