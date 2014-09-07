<?php
namespace org\zenolithe\cms\daos;

use org\zenolithe\cms\page\PageModel;
use org\zenolithe\cms\business\Domain;

Trait PagesServingDaoTrait {
	public function build($pageArray) {
		$article = null;
		
		if($pageArray) {
			$page = new PageModel($pageArray);
			$page->setDomain(new Domain($pageArray));
		}
		
		return $page;
	}
	
	public function getPageByUriAndLang($siteBase, $uri, $lang) {
		$page = null;
		$sql = 'SELECT *
		    		FROM cms_domains, cms_pages
		    		WHERE pge_uri = '.$this->quote($uri).'
		    		  AND pge_site_id = dom_site_id
		    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
		    		       OR (pge_status = '.PAGE_STATUS_PLANNED.'
		    		           AND pge_publish_date <= '.$this->quoteSmart(date('Y-m-d H:i:s', time())).' ))
		    		  AND dom_base = '.$this->quoteSmart($siteBase).'
		    		  AND pge_lang = '.$this->quoteSmart($lang).'
		    		ORDER BY pge_site_id DESC';
		
		$pageArray = $this->database->queryToArray($sql);
		if($pageArray) {
			$page = $this->build(array_pop($pageArray));
		}
		
		return $page;
	}
}
?>