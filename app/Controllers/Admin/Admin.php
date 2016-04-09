<?php
namespace App\Controllers\Admin;

use Core\controller;
use Core\View;
use Helpers\Session;
use Helpers\Url;

class Admin extends Controller
{
	public function __construct()
	{
		if (!Session::get('loggedin')) {
			Url::redirect('admin/login');
		}
	}

	public function index()
	{
		$data['title'] = 'Admin';

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/Admin', $data);
		View::renderTemplate('footer', $data, 'Admin');
	}
}
