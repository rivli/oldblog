<?php

class Controller_Choizze extends Controller
{

  function __construct()
  {
    $this->model = new Model_Choizze();
    $this->view = new View();
  }

  function action_index()
  {
    $data = $this->model->get_data();
    $this->view->generate(['content' => 'choizze_view.php','title' => 'Choizze'], 'template_view.php', $data);
  }
}
