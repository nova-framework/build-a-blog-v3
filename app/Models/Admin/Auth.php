<?php
namespace App\Models\Admin;

use Core\Model;

class Auth extends Model
{
	public function getHash($username)
	{
		$data = $this->db->select("SELECT password FROM ".PREFIX."members WHERE username = :username", array(':username' => $username));
		return $data[0]->password;
	}
}
