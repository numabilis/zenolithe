<?php
namespace org\zenolithe\kernel\mvc;

interface IModel {
	public function get($name);
	public function set($name, $value);
	public function getLocale();
	public function setLocale($locale);
	public function getViewName();
	public function setViewName($viewName);
}
?>