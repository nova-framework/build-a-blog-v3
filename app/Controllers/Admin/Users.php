<?php
namespace App\Controllers\Admin;

use Core\controller;
use Core\View;
use Helpers\Password;
use Helpers\Session;
use Helpers\Url;

class Users extends Controller
{
	private $model;

	public function __construct()
	{
		if (!Session::get('loggedin')) {
			Url::redirect('admin/login');
		}

		$this->model = new \App\Models\Admin\Users();
	}

	public function index()
	{
		$data['title'] = 'Users';
		$data['users'] = $this->model->getusers();

		View::renderTemplate('header', $data, 'Admin');
		View::render('admin/users', $data);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function add()
	{
		$data['title'] = 'Add User';

		if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];

			if($username == ''){
				$error[] = 'Username is required';
			}

			if($password == ''){
				$error[] = 'Password is required';
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    $error[] = 'Email is not valid';
			}

			if(!$error){
				$postdata = array(
					'username' => $username,
					'password' => Password::make($password),
					'email' => $email
				);
				$this->model->insertUser($postdata);

				Session::set('message', 'User Added');
				Url::redirect('admin/users');
			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('admin/adduser', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');

	}

	public function edit($id)
	{
		$data['title'] = 'Edit User';
		$data['row'] = $this->model->getuser($id);

		if (isset($_POST['submit'])) {

			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];

			if ($username == '') {
				$error[] = 'Username is required';
			}

			if ($password == '') {
				$error[] = 'Password is required';
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    $error[] = 'Email is not valid';
			}

			if (!$error) {
				$postdata = array(
					'username' => $username,
					'password' => Password::make($password),
					'email' => $email
				);
				$where = array('memberID' => $id);
				$this->model->updateUser($postdata,$where);

				Session::set('message','User Updated');
				Url::redirect('admin/users');
			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('admin/edituser', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}
}
