<?php
namespace org\zenolithe\cms\page;

use org\zenolithe\kernel\mvc\IModel;

interface IPageModel extends IModel {
	public function addMetaScriptLink($scriptLink);
	public function getMetaTitle();
	public function getMetaDescription();
	public function setNextPage($nextPage);
	public function setPreviousPage($previousPage);
	public function getCanonical();
	public function setCanonical($canonical);
	public function addContent($zone, $content);
	public function isHome();
	public function setHome($isHome);
}
?>