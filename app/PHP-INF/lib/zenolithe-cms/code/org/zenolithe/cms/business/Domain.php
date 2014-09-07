<?php
namespace org\zenolithe\cms\business;

class Domain {
	public $id;
	public $mnem;
	public $base;
	public $languages;
	public $siteId = 1;
	
	public function __construct($dbDomain=null) {
		if($dbDomain) {
			$this->id = $dbDomain['dom_id'];
			$this->mnem = $dbDomain['dom_mnem'];
			$this->base = $dbDomain['dom_base'];
			$this->languages = $dbDomain['dom_languages'];
			$this->siteId = $dbDomain['dom_site_id'];
		}
	}
}
?>