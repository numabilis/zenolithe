<?php
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\controllers\IController;

class org_zenolithe_acl_DisconnectController implements IController {
  public function handleRequest(Request $request) {
    session_start();
    session_destroy();
    $request->redirect(UrlProvider::getUrl('login.php'));
    
    return null;
  }
}
?>
