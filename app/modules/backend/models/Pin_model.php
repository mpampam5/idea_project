<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Model.php";

class Pin_model extends MY_Model{


function get_data_rekening(){
  return $this->db->query("SELECT
                            config_bank.id_rekening,
                            config_bank.id_bank,
                            config_bank.nama_rekening,
                            config_bank.no_rekening,
                            ref_bank.bank
                            FROM
                            config_bank
                            INNER JOIN ref_bank ON config_bank.id_bank = ref_bank.id
                            ")
                    ->result();
}


function json_order_pin()
{
  $this->datatables->select("trans_order_pin.id_order_pin,
                              trans_order_pin.id_member,
                              trans_order_pin.kode_transaksi,
                              trans_order_pin.stocklist_pembelian,
                              trans_order_pin.jumlah_pin,
                              format(trans_order_pin.jumlah_bayar,0) AS jumlah_bayar,
                              trans_order_pin.sumber_dana,
                              trans_order_pin.id_config_bank,
                              trans_order_pin.`status`,
                              DATE_FORMAT(trans_order_pin.tgl_order,'%d/%m/%Y %h:%i') AS tgl_order,
                              config_bank.nama_rekening,
                              config_bank.no_rekening,
                              ref_bank.bank");
  $this->datatables->from("trans_order_pin");
  $this->datatables->join("config_bank","config_bank.id_rekening = trans_order_pin.id_config_bank","left");
  $this->datatables->join("ref_bank","config_bank.id_bank = ref_bank.id","left");
  $this->datatables->where("id_member",sess('id_member'));
  return $this->datatables->generate();
}


} //END CLASS
