<?php
namespace org\zenolithe\kernel\log {
	class LoggerWrapper {
		static private $instance;
		private $logger;
	
		static public function getInstance() {
			return self::$instance;
		}
	
		public function __construct() {
			self::$instance = $this;
		}
		
		public function getLogger() {
			return $this->logger;
		}
		
		public function setLogger(ILogger $logger) {
			$this->logger = $logger;
		}
	
		public function error($message, $stack=null) {
			$this->logger->error($message, $stack);
		}
	
		public function warn($message) {
			$this->logger->warn($message);
		}
	
		public function info($message) {
			$this->logger->info($message);
		}

		public function debug($message=null) {
			$this->logger->debug($message);
		}
	}
}

namespace {
	use org\zenolithe\kernel\log\LoggerWrapper;
	
	function error($message, $stack=null) {
		LoggerWrapper::getInstance()->error($message, $stack);
	}
	
	function warn($message) {
		LoggerWrapper::getInstance()->warn($message);
	}
	
	function info($message) {
		LoggerWrapper::getInstance()->info($message);
	}
	
	function debug($message=null) {
		LoggerWrapper::getInstance()->debug($message);
	}
	
	function error_handler($errno, $errstr, $errfile, $errline, $errapp) {
		$logger = LoggerWrapper::getInstance()->getLogger();
		if($logger) {
			$logger->errorHandler($errno, $errstr, $errfile, $errline, $errapp);
		}
	}
	
	set_error_handler('error_handler');
	
	function exception_handler(Exception $exception) {
		$logger = LoggerWrapper::getInstance()->getLogger();
		if($logger) {
			$logger->exceptionHandler($exception);
		}
	}
	
	set_exception_handler('exception_handler');
	
	// Required function to log an exception.
// 	function exception_error(Exception $exception) {
// 		exception_handler($exception);
// 	}
}
?>