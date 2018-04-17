<?php

class Controller_404 extends Controller
{

	function action_index()
	{
			$this->view->generate(['content' =>'404_view.php', 'title' => "Page Not Found - Error 404"], 'template_view.php');
	}

}
