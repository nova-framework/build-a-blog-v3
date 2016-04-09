<?php
namespace App\Controllers\Admin;

use Core\controller;
use Core\View;
use Helpers\Session;
use Helpers\Url;

class Posts extends Controller
{
	private $model;
	private $catsmodel;

	function __construct()
	{
		if (!Session::get('loggedin')) {
			Url::redirect('admin/login');
		}

		$this->model = new \App\Models\Admin\Posts();
		$this->catsmodel = new \App\Models\Admin\Cats();
	}

	public function index()
	{
		$data['title'] = 'Posts';
		$data['posts'] = $this->model->getPosts();
		$data['js'] = "
		<script language='Javascript' type='text/javascript'>
		function delpost(id,title){
			if(confirm('Are you sure you want to delete the post '+ title)){
				window.location.href = '".DIR."admin/posts/delete/' + id;
			}
		}
		</script>
		";

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/Posts', $data);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function add()
	{
		$data['title'] = 'Add Post';
		$data['cats'] = $this->catsmodel->getCats();

		if (isset($_POST['submit'])) {
			$postTitle = $_POST['postTitle'];
			$postDesc = $_POST['postDesc'];
			$postCont = $_POST['postCont'];
			$catID = $_POST['catID'];

			if ($postTitle == '') {
				$error[] = 'Title is required';
			}

			if ($postDesc == '') {
				$error[] = 'Description is required';
			}

			if ($postCont == '') {
				$error[] = 'Content is required';
			}

			if ($catID == '') {
				$error[] = 'Select a category';
			}

			if (!$error) {
				$slug = Url::generateSafeSlug($postTitle);

				$data = array(
					'postTitle' => $postTitle,
					'postSlug' => $slug,
					'postDesc' => $postDesc,
					'postCont' => $postCont,
					'catID'    => $catID
				);

				if ($_FILES['image']['size'] > 0) {
					$file = 'images/'.$_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'], ROOTDIR.'assets/'.$file);
					$data['postImg'] = $file;
				}

				$this->model->insertPost($data);

				Session::set('message','Post added');
				Url::redirect('admin/posts');
			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/AddPost', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function edit($id)
	{
		$data['title'] = 'Edit Post';
		$data['row'] = $this->model->getPost($id);
		$data['cats'] = $this->catsmodel->getCats();

		if (isset($_POST['submit'])) {

			$postTitle = $_POST['postTitle'];
			$postDesc = $_POST['postDesc'];
			$postCont = $_POST['postCont'];
			$catID = $_POST['catID'];

			if ($postTitle == '') {
				$error[] = 'Title is required';
			}

			if ($postDesc == '') {
				$error[] = 'Description is required';
			}

			if ($postCont == '') {
				$error[] = 'Content is required';
			}

			if ($catID == '') {
				$error[] = 'Select a category';
			}

			if (!$error) {
				$slug = Url::generateSafeSlug($postTitle);

				$data = array(
					'postTitle' => $postTitle,
					'postSlug' => $slug,
					'postDesc' => $postDesc,
					'postCont' => $postCont,
					'catID'    => $catID
				);

				if ($_FILES['image']['size'] > 0) {
					$file = 'images/'.$_FILES['image']['name'];
					move_uploaded_file($_FILES['image']['tmp_name'], ROOTDIR.'assets/'.$file);
					$data['postImg'] = $file;
				}

				$where = array('postID' => $id);

				$this->model->updatePost($data, $where);

				Session::set('message', 'Post Updated');
				Url::redirect('admin/posts');
			}
		}

		View::renderTemplate('header', $data, 'Admin');
		View::render('Admin/EditPost', $data, $error);
		View::renderTemplate('footer', $data, 'Admin');
	}

	public function delete($id)
	{
		$this->model->deletePost(array('postID' => $id));
		Session::set('message','Post Deleted');
		Url::redirect('admin/posts');
	}
}
