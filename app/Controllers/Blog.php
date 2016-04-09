<?php
namespace App\Controllers;

use Core\Controller;
use Core\View;
use Helpers\Paginator;

class Blog extends Controller
{
	private $model;

	public function __construct()
	{
		$this->model = new \App\Models\Blog\Blog();
	}

	public function index()
	{
		$data['title'] = 'Welcome to the blog';

		$pages = new Paginator('10', 'page');
		$pages->setTotal(count($this->model->getPostsTotal()));
		$data['posts'] = $this->model->getposts($pages->getLimit());
		$data['page_links'] = $pages->pageLinks();
		$data['cats'] = $this->model->getCats();

		View::renderTemplate('header', $data);
		View::render('Blog/Index', $data);
		View::renderTemplate('footer', $data);
	}

	public function post($slug)
	{
		$data['post'] = $this->model->getPost($slug);
		$data['title'] = $data['post'][0]->postTitle;
		$data['cats'] = $this->model->getCats();

		View::renderTemplate('header', $data);
		View::render('Blog/Post', $data);
		View::renderTemplate('footer', $data);
	}

	public function cat($slug)
	{
		$pages = new Paginator('10', 'page');
		$pages->setTotal(count($this->model->getCatPostTotal($slug)));
		$data['posts'] = $this->model->getCatPosts($slug, $pages->getLimit());
		$data['page_links'] = $pages->pageLinks();
		$data['cats'] = $this->model->getCats();

		$data['title'] = $data['posts'][0]->catTitle;

		View::renderTemplate('header', $data);
		View::render('Blog/Cats', $data);
		View::renderTemplate('footer', $data);
	}
}
