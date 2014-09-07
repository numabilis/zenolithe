<?php
namespace org\zenolithe\kernel\bootstrap;

interface IApplicationContext {
	public function getHost();
	public function getRootPath();
	public function getZenolithePath();
}
?>