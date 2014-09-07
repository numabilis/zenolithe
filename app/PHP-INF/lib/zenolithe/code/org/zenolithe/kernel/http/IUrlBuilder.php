<?php
namespace org\zenolithe\kernel\http;

interface IUrlBuilder  {
	public function getServerUrlPart();
	public function getApplicationUrlPart();
	public function getModuleIndiceUrlPart();
	public function setModuleIndiceUrlPart($moduleIndiceUrlPart);
	public function getModuleUrlPart();
	public function setModuleUrlPart($moduleUrlPart);
	public function provideUrl($pageUrlPart, $lang=null);
	public function getBaseUrl();
	public function getUrl($pageUrlPart, $lang=null);
	public function getTranslatedUrl($lang);
}
?>
