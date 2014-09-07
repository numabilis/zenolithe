<?php
return array(
		'class' => 'org\zenolithe\cms\posts\PostsListController',
		'injected' => array(
				'categoriesDao' => 'cms/categories.dao',
				'postsDao' => 'cms/posts.dao'
		),
		'parameters' => array(
				'view' => 'admin/posts/list'
		)
);
?>