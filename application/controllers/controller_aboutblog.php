<?php

class Controller_Aboutblog extends Controller
{

  function __construct()
  {
    $this->model = new Model_Aboutblog();
    $this->view = new View();
  }

  function action_index()
  {
    $data = $this->model->get_data();
    $this->view->generate(['content' => 'aboutblog_view.php','title' => 'About blog'], 'template_view.php', $data);
  }
}
