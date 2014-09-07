<?php
namespace org\zenolithe\cms\posts;

use org\zenolithe\kernel\db\PostgreSQLDao;

class PostsDaoPg extends PostgreSQLDao implements IPostsDao {
	public function getAllPosts($categoryId) {
		$posts = array();
		
		$sql = 'SELECT *
		    		  FROM cms_pages, cms_articles, cms_categories, cms_posts
		    	   WHERE cat_id = '.$this->quote($categoryId).'
		    		   AND pot_category_id = cat_id
		    			 AND art_id = pot_article_id
		    	   	 AND pge_id = art_page_id
		    		 ORDER BY pge_publish_date ASC';
		$posts = $this->database->queryToArray($sql);
		
		return $posts;
	}
}
?>