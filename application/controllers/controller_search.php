<?php

class Controller_Search extends Controller
{

  function __construct()
  {
    $this->model = new Model_Search();
    $this->view = new View();
  }

  function action_index()
  {
    $data = $this->model->search();
    $this->view->generate(['content' => 'search_view.php','title' => 'Search'], 'template_view.php', $data);
  }

  function action_tag()
  {
		$routes = explode('/', $_SERVER['REQUEST_URI']);
    $data = $this->model->tag($routes[3]);
    $this->view->generate(['content' => 'search_view.php','title' => 'Tag Searching'], 'template_view.php', $data);
  }
}
