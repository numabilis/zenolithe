<?php
namespace org\zenolithe\kernel\bootstrap;

interface IModule {
	public function init();
	public function setUp();
	public function run();
	public function tearDown();
	public function finish();
}
?>