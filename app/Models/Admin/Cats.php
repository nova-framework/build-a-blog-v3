<?php
namespace App\Models\Admin;

use Core\Model;

class Cats extends Model
{
	public function getcats()
	{
		return $this->db->select("SELECT * FROM ".PREFIX."post_cats ORDER BY catID DESC");
	}

	public function getCat($id)
	{
		return $this->db->select("SELECT * FROM ".PREFIX."post_cats WHERE catID = :id", array(':id' => $id));
	}

	public function insertCat($data)
	{
		$this->db->insert(PREFIX."post_cats", $data);
	}

	public function updateCat($data,$where)
	{
		$this->db->update(PREFIX."post_cats", $data, $where);
	}

	public function deleteCat($where)
	{
		$this->db->delete(PREFIX."post_cats", $where);
	}
}
