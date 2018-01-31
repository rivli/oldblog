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
		$this->view->generate(['content' => 'blog_view.php','title' => 'Blog'], 'template_view.php', $data);
	}

	function action_cat()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->cat($routes[3]);
		$this->view->generate(['content' => 'cat_view.php','title' => 'Blog'], 'template_view.php', $data);
	}


	function action_article()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->article($routes[3]);
		$this->view->generate(['content' => 'article_view.php','title' => $data['name']], 'template_view.php', $data);
	}


/*
	function action_game()
	{
		$data = $this->model->get_data();
		$this->view->generate('mgame_view.php', 'template_view.php', $data);
	}*/

	function action_addpost()
	{
		$data = $this->model->add_post();
		$this->view->generate(['content' => 'addpost_view.php','title' => 'Add Post'], 'template_view.php', $data);
	}

	function action_query_addpost()
	{
		$data = $this->model->add_query_post($_POST);
		$this->view->generate(['content' => 'articleadded_view.php','title' => 'Add Post'], 'template_view.php', $data);
	}

	function action_signin()
	{
		$data = $this->model->signin($_POST);
		$this->view->generate(['content' => 'blog_view.php','title' => 'Blog'], 'template_view.php', $data);
	}

	function action_signout()
	{
		$data = $this->model->signout();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Blog'], 'template_view.php', $data);
	}

	function action_addcat()
	{
		if($_POST) {$data = $this->model->add_cat($_POST);} else {$data = "";};
		$this->view->generate(['content' => 'addcat_view.php','title' => 'Add Category'], 'template_view.php', $data);
	}

	function action_delete()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		$data = $this->model->delete($routes[3]);
		$this->view->generate(['content' => 'blog_view.php','title' => 'Blog'], 'template_view.php', $data);
	}

	function action_edit()
	{
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if($_POST) {
			$data = $this->model->edit($_POST);
		} else {
			$data = $this->model->article($routes[3]);
		};
		$this->view->generate(['content' => 'editarticle_view.php','title' => 'Edit '.$data['name']], 'template_view.php', $data);
	}
}
