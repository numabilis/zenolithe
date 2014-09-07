<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\cms\page\IPageModel;

class ParameterizedView extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		return null;
	}

	public function viewName() {
		return $this->parameter;
	}
}
?>
