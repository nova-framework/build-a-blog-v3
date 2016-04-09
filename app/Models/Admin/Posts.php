<?php
namespace App\Models\Admin;

use Core\Model;

class Posts extends Model
{
	public function getPosts()
	{
		return $this->db->select("
			SELECT
				".PREFIX."posts.postID,
				".PREFIX."posts.postTitle,
				".PREFIX."posts.postDate,
				".PREFIX."post_cats.catTitle
			FROM
				".PREFIX."posts,
				".PREFIX."post_cats
			WHERE
				".PREFIX."posts.catID = ".PREFIX."post_cats.catID
			ORDER BY
				postID DESC");
	}

	public function getPost($id)
	{
		return $this->db->select("SELECT * FROM ".PREFIX."posts WHERE postID = :id", array(':id' => $id));
	}

	public function insertPost($data)
	{
		$this->db->insert(PREFIX."posts", $data);
	}

	public function updatePost($data, $where)
	{
		$this->db->update(PREFIX."posts", $data, $where);
	}

	public function deletePost($where)
	{
		$this->db->delete(PREFIX."posts", $where);
	}
}
