<?php
namespace App\Models\Blog;

use Core\Model;

class Blog extends Model
{
	public function getPosts($limit)
	{
		return $this->db->select("
			SELECT
				".PREFIX."posts.postID,
				".PREFIX."posts.postTitle,
				".PREFIX."posts.postSlug,
				".PREFIX."posts.postDesc,
				".PREFIX."posts.postImg,
				".PREFIX."posts.postDate,
				".PREFIX."post_cats.catTitle,
				".PREFIX."post_cats.catSlug
			FROM
				".PREFIX."posts,
				".PREFIX."post_cats
			WHERE
				".PREFIX."posts.catID = ".PREFIX."post_cats.catID
			ORDER BY
				postID DESC ".$limit);
	}

	public function getPostsTotal()
	{
		return $this->db->select("SELECT postID FROM ".PREFIX."posts");
	}

	public function getPost($slug)
	{
		return $this->db->select("
			SELECT
				".PREFIX."posts.postID,
				".PREFIX."posts.postTitle,
				".PREFIX."posts.postSlug,
				".PREFIX."posts.postCont,
				".PREFIX."posts.postImg,
				".PREFIX."posts.postDate,
				".PREFIX."post_cats.catTitle,
				".PREFIX."post_cats.catSlug
			FROM
				".PREFIX."posts,
				".PREFIX."post_cats
			WHERE
				".PREFIX."posts.postSlug = :slug
				AND ".PREFIX."posts.catID = ".PREFIX."post_cats.catID
			",array(':slug' => $slug));
	}

	public function getCatPosts($slug,$limit)
	{
		return $this->db->select("
			SELECT
				".PREFIX."posts.postID,
				".PREFIX."posts.postTitle,
				".PREFIX."posts.postSlug,
				".PREFIX."posts.postDesc,
				".PREFIX."posts.postImg,
				".PREFIX."posts.postDate,
				".PREFIX."post_cats.catTitle,
				".PREFIX."post_cats.catSlug
			FROM
				".PREFIX."posts,
				".PREFIX."post_cats
			WHERE
				".PREFIX."post_cats.catSlug = :slug
				AND ".PREFIX."posts.catID = ".PREFIX."post_cats.catID
			ORDER BY
				postID DESC ".$limit,array(':slug' => $slug));
	}

	public function getCatPostTotal($slug)
	{
		return $this->db->select("
			SELECT
				".PREFIX."posts.postID
			FROM
				".PREFIX."posts,
				".PREFIX."post_cats
			WHERE
				".PREFIX."post_cats.catSlug = :slug
				AND ".PREFIX."posts.catID = ".PREFIX."post_cats.catID
			",array(':slug' => $slug));
	}

	public function getCats()
	{
		return $this->db->select("SELECT * FROM ".PREFIX."post_cats ORDER BY catTitle");
	}
}
