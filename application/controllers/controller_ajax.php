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
		$this->view->generate(['content' => 'ajax_view.php','title' => 'Blog'], 'ajax_view.php', $data);
	}

	function action_signin()
	{
		$data = $this->model->signin($_POST);
		$this->view->generate(['content' => 'ajax_view.php','title' => 'Add Post'], 'ajax_view.php', $data);
	}
}
