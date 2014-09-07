<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

require daf_file('zenolithe/cms/components/htmlblocks.daf');

class HtmlBlock extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		
		$html = select_htmlblock($this->id, $lang);
		$model->set('hbk_title', $html['hbk_title']);
		$model->set('hbk_content', $html['hbk_content']);
		
		return $model;
	}

	public function viewName() {
		return 'components/html-block';
	}

	public function getZone() {
		if($this->zone) {
			$zone = $this->zone;
		} else {
			$zone = $this->parameter;
		}

		return $zone;
	}
}
?>
