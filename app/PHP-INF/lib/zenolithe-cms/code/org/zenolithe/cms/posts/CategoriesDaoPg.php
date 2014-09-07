<?php
namespace org\zenolithe\cms\posts;

use org\zenolithe\kernel\db\PostgreSQLDao;

class CategoriesDaoPg extends PostgreSQLDao implements ICategoriesDao {
	public function getAllCategories($siteBase) {
		$categories = null;
		
		$sql = 'SELECT cms_categories.*
		    		FROM cms_categories, cms_domains
		    		WHERE dom_base = '.$this->quote($siteBase).'
		    		  AND cat_site_id = dom_site_id
		    		ORDER BY cat_name';
		$categories = $this->database->queryToArray($sql);
		
		return $categories;
	}
}
?>