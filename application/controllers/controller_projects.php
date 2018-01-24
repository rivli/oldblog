<?php

class Controller_Projects extends Controller
{

	function __construct()
	{
		$this->model = new Model_Projects();
		$this->view = new View();
	}

	function action_index()
	{
		$data = $this->model->get_data();
		$this->view->generate(['content' => 'projects_view.php','title' => 'Projects'], 'template_view.php', $data);
	}
}
