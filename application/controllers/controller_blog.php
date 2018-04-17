<?php

class Controller_Blog extends Controller
{

	function __construct()
	{
		$this->model = new Model_Blog();
		$this->view = new View();
	}

	function action_index()
	{
		$data = $this->model->get_data();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Блог'], 'template_view.php', $data);
	}

	function action_cat()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->cat($routes[3]);
		$this->view->generate(['content' => 'cat_view.php','title' => $data['thiscat']['name']], 'template_view.php', $data);
	}


	function action_article()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->article($routes[3]);
		$this->view->generate(['content' => 'article_view.php','title' => $data['name']], 'template_view.php', $data);
	}

	function action_addpost()
	{
		OnlyForAdmin();
		$data = $this->model->add_post();
		$this->view->generate(['content' => 'addpost_view.php','title' => 'Добавить статью'], 'template_view.php', $data);
	}

	function action_query_addpost()
	{
		OnlyForAdmin();
		$data = $this->model->add_query_post($_POST);
		$this->view->generate(['content' => 'articleadded_view.php','title' => 'Добавить статью'], 'template_view.php', $data);
	}

	function action_signin()
	{
		$data = $this->model->signin($_POST);
		$this->view->generate(['content' => 'blog_view.php','title' => 'Авторизация'], 'template_view.php', $data);
	}

	function action_signout()
	{
		$data = $this->model->signout();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Авторизация'], 'template_view.php', $data);
	}

	function action_addcat()
	{
		OnlyForAdmin();
		if($_POST) {$data = $this->model->add_cat($_POST);} else {$data = "";};
		$this->view->generate(['content' => 'addcat_view.php','title' => 'Добавить категорию'], 'template_view.php', $data);
	}

	function action_delete()
	{
		OnlyForAdmin();
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->delete($routes[3]);
		$this->view->generate(['content' => 'blog_view.php','title' => 'Удалить статью'], 'template_view.php', $data);
	}

	function action_edit()
	{
		OnlyForAdmin();
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if($_POST) {
			$data = $this->model->edit($_POST);
		} else {
			$data = $this->model->article($routes[3]);
		};
		$this->view->generate(['content' => 'editarticle_view.php','title' => 'Изменить '.$data['name']], 'template_view.php', $data);
	}

	function action_drafts()
	{
		OnlyForAdmin();
		$data = $this->model->drafts();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Черновики'], 'template_view.php', $data);
	}

	function action_deleted()
	{
		OnlyForAdmin();
		$data = $this->model->deleted();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Удаленные статьи'], 'template_view.php', $data);
	}
}
