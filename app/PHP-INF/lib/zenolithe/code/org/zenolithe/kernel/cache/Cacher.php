<?php
namespace org\zenolithe\kernel\cache;

use org\zenolithe\kernel\bootstrap\IModule;

class Cacher implements IModule {
	protected $cache;
	
	public function setCache($cache) {
		$this->cache = $cache;
	}
	
	public function init() {
		
	}
	
	public function setUp() {
		
	}
	
	public function run() {
		
	}
	
	public function tearDown() {
		
	}
	
	public function finish() {
		$this->cache->getClearOnExit();
	}
}