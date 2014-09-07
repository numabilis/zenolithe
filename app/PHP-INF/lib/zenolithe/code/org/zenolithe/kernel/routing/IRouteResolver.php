<?php
namespace org\zenolithe\kernel\routing;

use org\zenolithe\kernel\http\Request;

interface IRouteResolver {
  public function resolve(Request $request);
}
?>
