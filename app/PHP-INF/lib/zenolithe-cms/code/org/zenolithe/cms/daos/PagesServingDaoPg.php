<?php
namespace org\zenolithe\cms\daos;

use org\zenolithe\kernel\db\PostgreSQLDao;
use org\zenolithe\cms\page\PageModel;
use org\zenolithe\cms\business\Domain;

class PagesServingDaoPg extends PostgreSQLDao {
	public function build($pageArray) {
		$article = null;
		
		if($pageArray) {
			$page = new PageModel();
			$page->id = $pageArray['pge_id'];
			$page->siteId = $pageArray['pge_site_id'];
			$page->lang = $pageArray['pge_lang'];
			$page->uri = $pageArray['pge_uri'];
			$page->uriPart = $pageArray['pge_uri_part'];
			$page->controllerProperties = $pageArray['pge_ctrl_properties'];
			$page->contextId = $pageArray['pge_context_id'];
			$page->group = $pageArray['pge_group'];
			$page->parentGroup = $pageArray['pge_parent_group'];
			$page->title = $pageArray['pge_title'];
			$page->order = $pageArray['pge_order'];
			$page->status = $pageArray['pge_status'];
			$page->publishDate = $pageArray['pge_publish_date'];
			$page->description = $pageArray['pge_description'];
			$page->keywords = $pageArray['pge_keywords'];
			$page->robots = $pageArray['pge_robots'];
			$page->controllerClass = $pageArray['pge_controller'];
			$page->type = $pageArray['pge_type'];
			$page->metaTitle = $pageArray['pge_meta_title'];
			$page->shortTitle = $pageArray['pge_short_title'];
			$page->showInMenu = $pageArray['pge_menu'];
			
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
	
	public function getPageById($id) {
		$page = null;
		$sql = 'SELECT *
		    		FROM cms_domains, cms_pages
		    		WHERE pge_id = '.$this->quote($id);
		
		$pageArray = $this->database->queryToArray($sql);
		if($pageArray) {
			$page = $this->build(array_pop($pageArray));
		}
		
		return $page;
	}
}
?>