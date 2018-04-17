<?php

class Controller_Codex extends Controller
{

	function action_index()
	{
		$this->view->generate(['content' =>'codex_view.php', 'title' => "Ilvir Zakiryanov's codex"], 'template_view.php');
	}
}
