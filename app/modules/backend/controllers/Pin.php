<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Pin extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Pin_model','model');
  }



  function order_pin()
  {
    $this->template->set_title("Beli PIN");
    $data['kode_pin'] = "PIN".date('dmYhis');
    $this->template->view("content/pin/form_order_pin");
  }

} //end class
