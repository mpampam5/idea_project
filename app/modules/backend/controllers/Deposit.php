<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Deposit extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Deposit_model','model');
  }


  function add_deposit()
  {
    $this->template->set_title("Add Deposit");
    $this->template->view("content/deposit/list_add_deposit");
  }

  function json_add_deposit()
  {
    $this->load->library('Datatables');
    header('Content-Type: application/json');
    echo $this->model->json_deposit_add();
  }


  function add_new_deposit($button)
  {
    $data['button'] = $button;
    $this->template->view("content/deposit/form_add_deposit",$data,false);
  }

  function action_add_deposit()
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->form_validation->set_rules('nominal', 'Ammount', 'xss_clean|required|numeric');
        // $this->form_validation->set_rules('keterangan', 'Keterangan', 'xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required',[
          "required" => "Silahkan masukkan password anda untuk memastikan bahwa anda benar pemilik akun <b>".profile("nama")."</b>",
        ]);
        $this->form_validation->set_error_delimiters('<label class="error mt-2 text-danger">','</label>');
        if ($this->form_validation->run()) {
          $this->load->helper("pass_hash");
          $data = [
                          "id_member"  => sess('id_member'),
                          "nominal"    => $this->input->post('nominal',true),
                          // "keterangan" => $this->input->post("keterangan",true),
                          "status"    => "pending",
                          "created"    => date('Y-m-d h:i:s')
                    ];
          $this->model->get_insert("trans_member_deposit",$data);
          $json['alert'] = "Add New Deposit Berhasil Di Tambahkan. Silahkan Menunggu Prosess Verifikasi Admin";
          $json['success'] =  true;
        }else {
          foreach ($_POST as $key => $value)
            {
              $json['alert'][$key] = form_error($key);
            }
        }

        echo json_encode($json);
    }
  }

}
