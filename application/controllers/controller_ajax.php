<?php

class Controller_Ajax extends Controller
{

	function __construct()
	{
		$this->model = new Model_Ajax();
		$this->view = new View();
	}

	function action_index()
	{
		$data = $this->model->get_data();
		$this->view->generate(['content' => 'blog_view.php','title' => 'Blog'], 'template_view.php', $data);
	}

	function action_dimension()
	{
		$data = $this->model->dimension();
		$this->view->generate(['content' => 'ajax_view.php','title' => 'Blog'], 'cleartemplate_view.php', $data);
	}
}
