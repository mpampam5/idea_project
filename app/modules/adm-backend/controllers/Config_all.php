<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/adm-backend/core/MY_Controller.php";

class Config_all extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Config_all_model','model');
  }

  function index()
  {
    if ($row = $this->model->get_where('config_all',["id_config"=>1])) {
      $this->template->set_title("Umum");
      $data['row'] = $row;
      $this->template->view("content/config_all/index",$data);
    }else {
      $this->_error404();
    }
  }

}
