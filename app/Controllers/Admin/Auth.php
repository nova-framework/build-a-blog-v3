<?php
namespace App\Controllers\Admin;

use Core\controller;
use Core\View;
use Helpers\Session;
use Helpers\Url;
use Helpers\Password;

class Auth extends Controller
{
    public function login()
    {
        if (Session::get('loggedin')) {
		    Url::redirect('admin');
        }

		$model = new \App\Models\Admin\Auth();

		$data['title'] = 'Login';

		if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			if (Password::verify($password, $model->getHash($_POST['username'])) == 0) {
				$error[] = 'Wrong username of password';
			} else {
				Session::set('loggedin',true);
				Url::redirect('admin');
			}

		}

		View::renderTemplate('loginheader', $data, 'Admin');
		View::render('admin/login',$data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function logout()
	{
		Session::destroy();
		Url::redirect('admin/login');
	}
}
