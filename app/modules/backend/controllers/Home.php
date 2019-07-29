<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Home extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Pohon_model','model');
  }

  function index()
  {
    $this->template->set_title('Home');
    $data['deposit'] = $this->blance->deposit(sess('id_member'));
    $this->template->view('index',$data);
  }




}
