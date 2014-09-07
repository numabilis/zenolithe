<?php
namespace org\zenolithe\cms\posts;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\SimpleModel;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file('zenolithe/cms/domains-admin.daf');
require daf_file('zenolithe/cms/pages-admin.daf');

class PostsListController implements IController {
	protected $view ;
	private $categoriesDao;
	private $postsDao;
	
	public function setView($view) {
		$this->view = $view;
	}
	
	public function setCategoriesDao(ICategoriesDao $categoriesDao) {
		$this->categoriesDao = $categoriesDao;
	}
	
	public function setPostsDao(IPostsDao $postsDao) {
		$this->postsDao = $postsDao;
	}
	
	public function handleRequest(Request $request) {
		$model = new SimpleModel();
		
		$domain = $request->getSession()->getAttribute('edited-domain');
		$categories = $this->categoriesDao->getAllCategories($domain['dom_base']);
		$model->set('categories', $categories);
		$categoryId = $request->getParameter('category');
		if(!$categoryId) {
			$categoryId = $categories[0]['cat_id'];
		}
		$model->set('category', $categoryId);
		$postsList = array();
		$posts = $this->postsDao->getAllPosts($categoryId);
		if($posts) {
			foreach($posts as $post) {
				$postsList[$post['pge_group']][$post['pge_lang']] = $post;
			}
		}
		$model->set('posts', $postsList);
		
		$model->setViewName($this->view);

		return $model;
	}
}
?>