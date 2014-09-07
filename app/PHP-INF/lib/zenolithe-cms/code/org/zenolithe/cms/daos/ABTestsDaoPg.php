<?php
namespace org\zenolithe\cms\daos;

use org\zenolithe\kernel\db\PostgreSQLDao;
use org\zenolithe\cms\abtesting\ABTest;

class ABTestsDaoPg extends PostgreSQLDao {
	protected function build($abtestArray) {
		$abtest = null;
		
		if($abtestArray) {
			$abtest = new ABTest();
			$abtest->setId($abtestArray['abt_id']);
			$abtest->setName($abtestArray['abt_name']);
			$abtest->setLang($abtestArray['abt_lang']);
			$abtest->setUri($abtestArray['abt_uri']);
			$abtest->setSiteId($abtestArray['abt_site_id']);
			$abtest->setPageId($abtestArray['abt_page_id']);
			$abtest->setParameter($abtestArray['abt_parameter']);
		}
		
		return $abtest;
	}
	
	public function getTestByUriAndLang($siteBase, $uri, $lang) {
		$abtest = null;
		$sql = 'SELECT *
		    		FROM cms_domains, cms_abtests
		    		WHERE abt_uri = '.$this->quote($uri).'
		    		  AND abt_site_id = dom_site_id
		    		  AND dom_base = '.$this->quoteSmart($siteBase).'
		    		  AND abt_lang = '.$this->quoteSmart($lang).'
		    		ORDER BY abt_site_id DESC';
		
		$abtestArray = $this->database->queryToArray($sql);
		if($abtestArray) {
			$abtest = $this->build(array_pop($abtestArray));
		}
		
		return $abtest;
	}
}
?>