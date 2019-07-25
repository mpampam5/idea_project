<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Member extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Contoh_model','model');
  }


  function index()
  {
    $root = $this->db->get->where("");
  }


} //end class contoh
