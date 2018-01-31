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


}
