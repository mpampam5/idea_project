<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Pin extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Pin_model','model');
    $this->load->library(array("btree"));
  }



  function order_pin()
  {
    $this->template->set_title("Beli PIN");
    $kode_pin_trans = 'KPN-'.date('dmYhis');
    $data['action'] = site_url("backend/pin/order_pin_action/$kode_pin_trans");
    $data['bank'] = $this->model->get_data_rekening();
    $this->template->view("content/pin/form_order_pin",$data);
  }


  function order_pin_action($kode_pin_trans)
  {
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $jumlah_pin   = $this->input->post("jumlah_pin",true);
        $sumber_dana  = $this->input->post("sumber_dana",true);
        $stocklist    = $this->input->post("stocklist",true);

        $jumlah_bayar = ($jumlah_pin*config_all('harga_pin'));

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

            $trans_pin = array('id_order_pin'     => $last_id_order_pin,
                               'kode_pin_trans'   => $kode_pin_trans,
                               'key_order_pin'    => $kode_pin_trans."-$i",
                               'id_member_punya'  => sess('id_member'),
                              );
            $this->model->get_insert("trans_pin",$trans_pin);
              }
          }

          $json['alert'] = "Transaksi Order PIN Berhasil.";
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


function list_pin()
{
  $this->template->set_title("Daftar PIN");
  $this->template->view("content/pin/list_pin");
}


function json_list_pin()
{
  $this->load->library('Datatables');
  header('Content-Type: application/json');
  echo $this->model->json_pin();
}


function Detail($id)
{
  if ($row=$this->model->detail_order_pin($id)) {
      $this->template->set_title("Detail");
      $data['row'] = $row;
      $this->template->view("content/pin/detail",$data);
  }else {
      $this->_error404();
  }

}


function delete($id)
{
  if ($this->input->is_ajax_request()) {
        $this->db->where('id_order_pin', $id)
                 ->delete('trans_order_pin');
        $json['alert']   = 'Berhasil menghapus.';
    echo json_encode($json);
  }
}

//TRANSFER PIN

function transfer_pin()
{
  $this->template->set_title("Transfer PIN");
  $this->template->view("content/pin/form_transfer_pin");
}



function transfer_pin_cek_usename()
{
  if ($this->input->is_ajax_request()) {
      $json = array('success'=>false, 'alert'=>array());
      if (profile('status_stockis')=="member") {
        $json['success']=false;
        $json['alert'] = "tidak valid";
      }else {
        $json['success']=true;
        $json['alert'] = $this->input->post("username");
      }

      echo json_encode($json);
  }
}


function contoh()
{
  $btree = $this->btree->get_all_id_children(sess('id_member'));
  // print_r($btree);
  echo json_encode($btree);
  // $data = array_merge_recursive($btree);
  // var_dump($btree);
}




} //end class
