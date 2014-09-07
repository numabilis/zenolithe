<?php
namespace org\zenolithe\cms\posts;

interface IPostsDao {
	public function getAllPosts($categoryId);
}
?>