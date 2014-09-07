<?php
namespace org\zenolithe\cms\components;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\cms\page\IPageModel;

class GalleryBlock extends Component {
	public function getComponentModel(Request $request, IPageModel $pageModel, $lang) {
		$model = new SimpleModel();
		$urls = array();
		
		$parameters = explode('#', $this->parameter);
		$folderPath = $_SERVER['DOCUMENT_ROOT'].'/'.$parameters[0];
		$model->set('imagesCount', $parameters[1]);
		
		$images = array();
		if(is_dir($folderPath) && ($dirHandle = opendir($folderPath))) {
			while(false !== ($entry = readdir($dirHandle))) {
				if($entry != "." && $entry != "..") {
					if(!is_dir($entry) && (strpos($entry, '.') !== false)) {
						$fileVersion = filemtime($folderPath.$entry);
						$url = static_url($parameters[0].$entry.'?v='.$fileVersion);
						$alt = $entry;
						$images[] = array('url' => $url, 'alt' => $alt);
					}
				}
			}
			closedir($dirHandle);
		}
		shuffle($images);
		$model->set('images', $images);
		
		return $model;
	}

	public function viewName() {
		return 'components/gallery-block';
	}
}
?>
