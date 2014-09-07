<?php
use org\zenolithe\kernel\ioc\IocContainer;
use org\zenolithe\kernel\http\UrlProvider;

UrlProvider::$builder = IocContainer::getInstance()->get('urlBuilder');

function static_url($pageUrlPart) {
	$url = '';
	$container = IocContainer::getInstance();
	
	$file = $container->get('application.path').'/'.$pageUrlPart;
	if(file_exists($file)) {
		$url = $container->get('urlBuilder')->getUrl($pageUrlPart.'?v='.filemtime($file));
	} else {
		$url = $container->get('urlBuilder')->getUrl($pageUrlPart);
	}
	
	return $url;
}
?>