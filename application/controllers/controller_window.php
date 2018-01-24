<?php

class Controller_Window extends Controller
{

	function action_index()
	{
    $this->view->generate(['content' =>'window_information_view.php', 'title' => "Ilvir Zakiryanov's site"], 'cleartemplate_view.php');
	}


  function action_information()
	{
		$this->view->generate(['content' =>'window_information_view.php', 'title' => "Ilvir Zakiryanov's site"], 'cleartemplate_view.php');
	}
}
