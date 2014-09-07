<?php
namespace org\zenolithe\kernel\mvc\controllers;

use org\zenolithe\kernel\http\Request;

interface IController {
  public function handleRequest(Request $request);
}
?>
