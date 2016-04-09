<?php
namespace App\Models\Admin;

use Core\Model;

class Users extends Model
{
	public function getUsers()
	{
		return $this->db->select("SELECT * FROM ".PREFIX."members ORDER BY username");
	}

	public function getUser($id)
	{
		return $this->db->select("SELECT * FROM ".PREFIX."members WHERE memberID = :id", array(':id' => $id));
	}

	public function insertUser($data)
	{
		$this->db->insert(PREFIX."members", $data);
	}

	public function updateUser($data, $where)
	{
		$this->db->update(PREFIX."members", $data, $where);
	}
}
