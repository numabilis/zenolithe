<?php
namespace org\zenolithe\kernel\log;

interface ILogger {
	public function error($message, $stack=null);
	public function warn($message);
	public function info($message);
	public function debug($message=null);
	public function errorHandler($errno, $errstr, $errfile=null, $errline=0, array $errcontext=null);
	public function exceptionHandler(Exception $exception);
}
?>
