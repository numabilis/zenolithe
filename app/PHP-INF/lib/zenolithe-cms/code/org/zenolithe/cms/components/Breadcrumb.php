<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class Breadcrumb extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();

		$pages = array_reverse (select_breadcrumb(UrlProvider::getbaseUrl(), $request->getAttribute('page')->uri, $lang));
		foreach($pages as $page) {
			if($page['pge_short_title']) {
				$model->set($page['pge_short_title'], $page['pge_uri']);
			}
		}
		
		if($pageModel->getShortTitle()) {
			$model->set($pageModel->getShortTitle(), '');
		}

		return $model;
	}

	public function viewName() {
		return 'components/breadcrumb';
	}
}
?>
