<?php
namespace App\Controllers\Admin;

use Core\controller;
use Core\View;
use Helpers\Session;
use Helpers\Url;

class Cats extends Controller
{
	private $model;

	function __construct()
	{
		if (!Session::get('loggedin')) {
			Url::redirect('admin/login');
		}

		$this->model = new \App\Models\Admin\Cats();
	}

	public function index()
	{
		$data['title'] = 'Cats';
		$data['cats'] = $this->model->getCats();
		$data['js'] = "
		<script language='Javascript' type='text/javascript'>
		function delcat(id,title){
			if(confirm('Are you sure you want to delete the post '+ title)){
				window.location.href = '".DIR."admin/cats/delete/' + id;
			}
		}
		</script>
		";

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/Cats', $data);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function add()
	{
		$data['title'] = 'Add Category';

		if (isset($_POST['submit'])) {

			$catTitle = $_POST['catTitle'];

			if ($catTitle == '') {
				$error[] = 'Title is required';
			}

			if(!$error){

				$slug = Url::generateSafeSlug($catTitle);

				$data = array(
					'catTitle' => $catTitle,
					'catSlug' => $slug
				);
				$this->model->insertCat($data);

				Session::set('message','Category added');
				Url::redirect('admin/cats');

			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/AddCat', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function edit($id)
	{
		$data['title'] = 'Edit Category';
		$data['row'] = $this->model->getCat($id);

		if (isset($_POST['submit'])) {
			$catTitle = $_POST['catTitle'];

			if ($catTitle == '') {
				$error[] = 'Title is required';
			}

			if (!$error) {
				$slug = Url::generateSafeSlug($catTitle);

				$data = array(
					'catTitle' => $catTitle,
					'catSlug' => $slug
				);
				$where = array('catID' => $id);

				$this->model->updateCat($data,$where);

				Session::set('message', 'Category Updated');
				Url::redirect('admin/cats');

			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/EditCat', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function delete($id)
	{
		$this->model->deleteCat(array('catID' => $id));
		Session::set('message','Category Deleted');
		Url::redirect('admin/cats');
	}
}
