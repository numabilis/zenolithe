<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class Menu extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		$parent = $this->parameter;
		$group = -1;
		
		$requestUrlParts = explode('/', $request->url);
		$menuLevel = select_menu_pages_by_parent_and_lang($request->getAttribute('page')->getDomain()->siteId, 0, $lang);
		$n = count($menuLevel);
		for($i=0; $i<$n; $i++) {
			$pos = strpos($menuLevel[$i]['pge_uri'], $requestUrlParts[0].'/');
			if((($pos !== false) && ($pos == 0)) || (($request->url == '') && ($menuLevel[$i]['pge_uri'] == ''))){
				$menuLevel[$i]['on-path'] = true;
				$model->set('menu-level2-title', $menuLevel[$i]['pge_short_title']);
				$group = $menuLevel[$i]['pge_group'];
			} else {
				$menuLevel[$i]['on-path'] = false;
			}
		}
		$model->set('menu-level1', $menuLevel);
		
//    $pos = strpos($request->url, '/', strlen($lang)+1);
    $menuLevel = select_menu_pages_by_parent_and_lang($request->getAttribute('page')->getDomain()->siteId, $group, $lang);
    $n = count($menuLevel);
    $pos = false;
    for($i=0; $i<$n; $i++) {
      if($requestUrlParts[1]) {
        $pos = strpos($menuLevel[$i]['pge_uri'], $requestUrlParts[0].'/'.$requestUrlParts[1]);
      }
      if(($pos !== false) && ($pos == 0)) {
        $menuLevel[$i]['on-path'] = true;
      } else {
        $menuLevel[$i]['on-path'] = false;
      }
    }
    $model->set('menu-level2', $menuLevel);
    
		return $model;
	}

	public function viewName() {
		return 'components/menu';
	}
}
?>
