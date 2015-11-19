<?php
namespace org\zenolithe\kernel\pdf {

	use org\zenolithe\kernel\bootstrap\IModule;
	
	class PdfGenerator implements IModule {
		public function init() {
			//spl_autoload_register('TCPDFAutoload', true, false);
			if(version_compare(PHP_VERSION, '5.1.2', '>=')) {
				// SPL autoloading was introduced in PHP 5.1.2
				if(version_compare(PHP_VERSION, '5.3.0', '>=')) {
					spl_autoload_register('TCPDFAutoload', true, false);
				} else {
					spl_autoload_register('TCPDFAutoload');
				}
			} else {
				/**
				 * Fall back to traditional autoload for old PHP versions
				 * @param string $classname The name of the class to load
				 */
				function __autoload($classname) {
					TCPDFAutoload($classname);
				}
			}
		}
		
		public function setUp() {
		}
		
		public function run() {
		}
		
		public function tearDown() {
		}
		
		public function finish() {
		}
	}
}

namespace {
	function TCPDFAutoload($className) {
		$class_file_path = strtolower($className).'.php';
		if((@include 'code/'.$class_file_path) !== 1) {
			$class_file_path = str_replace('\\', '/', $className) . '.php';
			@include 'code/'.$class_file_path;
		}
	}
}