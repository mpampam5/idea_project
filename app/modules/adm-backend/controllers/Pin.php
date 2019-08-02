<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/adm-backend/core/MY_Controller.php";

class Pin extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Pin_model','model');
  }


  function pin_order_terverifikasi()
  {
    $this->template->set_title("PIN Order Terverifikasi");
    $this->template->view("content/pin/list_pin_verif");
  }

  function json_pin_order_terverifikasi()
  {
    $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json_pin_verif_order();
  }









}
