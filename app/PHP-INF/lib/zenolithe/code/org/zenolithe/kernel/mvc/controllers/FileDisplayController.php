<?php
namespace org\zenolithe\kernel\mvc\controllers;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;

class FileDisplayController implements IController {
	public $fileName;
	
	public function getFileName() {
		return $this->fileName;
	}
	
	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}
	
  public function handleRequest(Request $request) {
  	$model = new SimpleModel();
  	$model->set('filename', $this->fileName);
  	$model->setViewName('commons/file-display');
  	
  	return $model;
  }
}
?>
