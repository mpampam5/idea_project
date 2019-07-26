<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Member extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Member_model','model');
  }

  function menunggu_verifikasi()
  {
    $this->template->set_title("Waiting");
    $this->template->view("content/member/menunggu_verifikasi");
  }

  function json_menunggu_verif()
  {
        $this->load->library('Datatables');
        header('Content-Type: application/json');
        echo $this->model->json_menunggu_verif();
  }


  function detail_member_menunggu_verif($id){
    $where = ["tb_member.id_member" =>$id];
    if ($row = $this->model->detail_member_menunggu_verif($where)) {
      $this->template->set_title("Waiting");
      $data["button"] = "Detail";
      $data["row"] = $row;
      $this->template->view("content/member/detail_menunggu_verifikasi",$data);
    }else {
      $this->_error404();
    }
  }



  function my_referral()
  {
    $this->template->set_title("Referral");
    $this->template->view("content/member/my_referral");
  }

  function json_my_referral()
  {
        $this->load->library('Datatables');
        header('Content-Type: application/json');
        echo $this->model->json_my_referral();
  }





} //end Class Member
