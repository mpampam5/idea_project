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
    $this->template->set_title("PIN Order Approved");
    $this->template->view("content/pin/list_pin_verif");
  }

  function json_pin_order_terverifikasi()
  {
    $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json_pin_verif_order();
  }

  function pin_order_pending()
  {
    $this->template->set_title("PIN Order Pending");
    $this->template->view("content/pin/list_pin_pending");
  }

  function json_pin_order_pending()
  {
    $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json_pin_pending_order();
  }


  function detail($id)
  {
    if ($row = $this->model->detail_pin_order($id)) {
      $this->template->set_title("Detail");
      $data['row'] = $row;
      $this->template->view("content/pin/detail",$data);
    }else {
      $this->_error404();
    }
  }









}
