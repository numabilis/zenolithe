<?php
/*
 *
 * Created on 14 févr. 07 by David Jourand
 *
 */
namespace org\zenolithe\kernel\mvc\controllers;

use org\zenolithe\kernel\http\Request;

class RedirectController implements IController {
  private $url;
  private $code = 303;
  
  public function getUrl() {
  	return $this->url;
  }
  
  public function setUrl($url) {
  	$this->url = $url;
  }
  
  public function getCode() {
  	return $this->code;
  }
  
  public function setCode($code) {
  	$this->code = $code;
  }
  
  public function handleRequest(Request $request) {
  	$request->redirect($this->url, $this->code);
  	
    return null;
  }
}
?>
