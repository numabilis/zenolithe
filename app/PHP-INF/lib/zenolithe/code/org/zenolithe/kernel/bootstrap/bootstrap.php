<?php
/**
 *
 * 16-mai-06 - david : Creation
 *
 */

use org\zenolithe\kernel\ioc\IocContainer;

error_reporting(E_ALL);
ini_set('log_errors', true);
ini_set('error_log', realpath($applicationPath.'../logs').'/php.log');
ini_set('display_errors', false);

// Timing initialization
$time_begin = getrusage();
$mtime_begin = microtime();

// Autoloading function
function autoloader($className) {
	$class_file_path = str_replace('_', '/', $className) . '.php';
	if((@include 'code/'.$class_file_path) !== 1) {
		$class_file_path = str_replace('\\', '/', $className) . '.php';
		@include 'code/'.$class_file_path;
	}
}
spl_autoload_register('autoloader');

// Setup include path
$appRootPath = substr(__DIR__, 0, strlen(__DIR__) - 57);
$zenolitheRootPath = $appRootPath.'PHP-INF/';
$includepath = get_include_path();
$paths = require($appRootPath.'PHP-INF/conf/includepath.conf.php');
foreach($paths as $path) {
	$includepath .= PATH_SEPARATOR.$zenolitheRootPath.$path;
}
set_include_path($includepath.PATH_SEPARATOR.$zenolitheRootPath);

$host = $_SERVER['SERVER_NAME'];
/* Ioc Container initialization */
$appConf = require('conf/app.conf.php');
if($appConf['context.debug']) {
	$name = stream_resolve_include_path('conf/hosts/'.$host.'.conf.php');
	if(is_file($name)) {
		$appConf = array_merge($appConf, require($name));
	}
	$name = stream_resolve_include_path('conf/app.debug.conf.php');
	if(is_file($name)) {
		$appConf = array_merge($appConf, require($name));
	}
	$name = stream_resolve_include_path('conf/hosts/'.$host.'.debug.conf.php');
	if(is_file($name)) {
		$appConf = array_merge($appConf, require($name));
	}
}
$name = stream_resolve_include_path('conf/hosts/'.$host.'.conf.php');
if(is_file($name)) {
	$appConf = array_merge($appConf, require($name));
}
$appConf['application.path'] = $appRootPath;
//$appConf['application.base'] = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
$name = substr($_SERVER['SCRIPT_FILENAME'], strlen($_SERVER['DOCUMENT_ROOT']));
$appConf['application.base'] = substr($name, 0, strrpos($name, '/')+1);
$appConf['application.host'] = $_SERVER['SERVER_NAME'];
$appConf['zenolithe.root'] = $zenolitheRootPath;

$container = IocContainer::getInstance($appConf);
if($container->get('includes')) {
	foreach($container->get('includes') as $file) {
		require($file);
	}
}

// TODO : remove that code
/*
global $dbType;
$dbType = strtolower($container->get('database')->getType());
function daf_file($daf_filename) {
	global $dbType;
	if(!defined($daf_filename)) {
		define($daf_filename, true);
		$filename = 'code/dafs/'.$dbType.'/'.$daf_filename .'.php';
	} else {
		$filename = 'code/dafs/empty.daf.php';
	}

	return $filename;
}
*/

$modules = require('conf/modules.conf.php');
foreach($modules as $module) {
	$container->get($module)->init();
}
foreach($modules as $module) {
	$container->get($module)->setUp();
}
foreach($modules as $module) {
	$container->get($module)->run();
}
foreach($modules as $module) {
	$container->get($module)->tearDown();
}
foreach($modules as $module) {
	$container->get($module)->finish();
}

$time_end = getrusage();
if($appConf['context.debug']) {
	$utime_begin = $time_begin["ru_utime.tv_sec"]*1000000 + $time_begin["ru_utime.tv_usec"];
	$stime_begin = $time_begin["ru_stime.tv_sec"]*1000000 + $time_begin["ru_stime.tv_usec"];
	$utime = round(($time_end["ru_utime.tv_sec"]*1000000 + $time_end["ru_utime.tv_usec"] - $utime_begin)/1000);
	$stime = round(($time_end["ru_stime.tv_sec"]*1000000 + $time_end["ru_stime.tv_usec"] - $stime_begin)/1000);
	list($sec, $usec) = explode(" ", $mtime_begin);
	$etime_begin = (float) $sec + (float )$usec;
	list($sec,$usec)=explode(" ",microtime());
	$etime = round(((float) $sec + (float) $usec - $etime_begin)*1000);
	$uri = '';
	if(isset($_SERVER['SCRIPT_URI'])) {
		$uri = $_SERVER['SCRIPT_URI'];
	} else if(isset($_SERVER['REQUEST_URI'])) {
		$uri = $_SERVER['REQUEST_URI'];
	}
	debug($uri." [U: ".$utime." ms | S: ".$stime." ms | T: ".($utime+$stime)." ms | E: ".$etime." ms]");
}
?>
