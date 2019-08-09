<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Contoh extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    // $this->load->model('Contoh_model','model');
  }


  function index()
  {
    $this->template->set_title('contoh');
    $this->template->view("content/contoh/index");
  }


} //end class contoh
