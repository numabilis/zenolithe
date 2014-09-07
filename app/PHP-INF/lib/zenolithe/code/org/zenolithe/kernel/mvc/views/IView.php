<?php
namespace org\zenolithe\kernel\mvc\views;

use org\zenolithe\kernel\mvc\IModel;

interface IView {
	public function getString($key, $lang=null, $strict=false);
	public function render(IModel $model, $exception=null);
}
?>