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
    $data['action'] = site_url("backend/pin/order_pin_action");
    $data['bank'] = $this->model->get_data_rekening();
    $this->template->view("content/pin/form_order_pin",$data);
  }


  function order_pin_action()
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $jumlah_pin   = $this->input->post("jumlah_pin",true);
        $sumber_dana  = $this->input->post("sumber_dana",true);
        $stocklist    = $this->input->post("stocklist",true);

        $jumlah_bayar = ($jumlah_pin*150000);

        if ($sumber_dana=="balance") {
          $id_config_bank = null;
          $status = "approved";
          $this->form_validation->set_rules('pembayaran', 'Total Pembayaran', 'trim|xss_clean|required|callback__cek_balance');
        }else {
          $id_config_bank = $this->input->post('rekening',true);
          $status = "pending";
          $this->form_validation->set_rules('pembayaran', 'Total Pembayaran', 'trim|xss_clean|required');
        }




        $this->form_validation->set_rules('jumlah_pin', 'Jumlah PIN', 'trim|xss_clean|required|numeric|callback__cek_jml_pin');

        $this->form_validation->set_rules('stocklist', 'Stocklist Pembelian', 'trim|xss_clean|required');
        $this->form_validation->set_rules('sumber_dana', 'Sumber Dana', 'trim|xss_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback__cek_password',[
          "required" => "Silahkan masukkan password anda untuk memastikan bahwa anda benar pemilik akun <b>".profile("nama")."</b>",
        ]);

        $this->form_validation->set_error_delimiters('<label class="error mt-2 text-danger">','</label>');






        if ($this->form_validation->run()) {


          $data = array(  'id_member'           => sess('id_member'),
                          'kode_transaksi'      => "PIN-".date('dmYhis'),
                          'stocklist_pembelian' => $stocklist,
                          'jumlah_pin'          => $jumlah_pin ,
                          'jumlah_bayar'        => $jumlah_bayar,
                          'sumber_dana'         => $sumber_dana,
                          'id_config_bank'      => $id_config_bank,
                          'status'              => $status,
                          'tgl_order'           => date('Y-m-d h:i:s')

                        );

          $this->model->get_insert("trans_order_pin",$data);


          $last_id_order_pin = $this->db->insert_id();
          if ($sumber_dana=="balance") {
            for ($i=0; $i < $jumlah_pin  ; $i++) {
            
            $trans_pin = array('id_order_pin' => $last_id_order_pin,
                                'status'      => "belum"
                              );
            $this->model->get_insert("trans_pin",$trans_pin);
              }
          }

          $json['alert'] = "Pembelian PIN Berhasil.";
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



  function _cek_balance($str)
  {

    $balance = $this->balance->total_balance(sess('id_member'));
    if ($str <= $balance) {
        return true;
    }else {
        $this->form_validation->set_message('_cek_balance', 'Total BALANCE anda tidak mencukupi. total BALANCE anda Rp. '.format_rupiah($balance).'. Silahkan ganti metode pembayaran atau melakukan deposit');
        return false;
    }
  }

  function _cek_jml_pin($str)
  {
    if ($str > 0) {
      return true;
    }else {
      $this->form_validation->set_message('_cek_jml_pin', 'Silahkan masukkan jumlah PIN yang di inginkan.');
      return false;
    }
  }




function list_order_pin()
{
  $this->template->set_title("Daftar Order PIN");
  $this->template->view("content/pin/list_order_pin");
}

function json_list_order_pin()
{
  $this->load->library('Datatables');
  header('Content-Type: application/json');
  echo $this->model->json_order_pin();
}

















} //end class
