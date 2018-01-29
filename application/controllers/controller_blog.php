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
}
