<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Model.php";

class Pohon_model extends MY_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }


  function query_cek_pin($limit)
  {
    return $this->db->query("SELECT
                              trans_order_pin.id_order_pin,
                              trans_order_pin.id_member,
                              trans_order_pin.kode_transaksi,
                              trans_pin.id_pin_trans,
                              trans_pin.kode_pin_trans,
                              trans_pin.key_order_pin,
                              trans_pin.status
                            FROM
                              trans_order_pin
                            INNER JOIN
                              trans_pin ON trans_pin.id_order_pin = trans_order_pin.id_order_pin
                            WHERE
                              trans_order_pin.id_member=".sess('id_member')." AND
                              trans_pin.status = 'belum'
                            ORDER BY
                              trans_order_pin.id_order_pin DESC
                            LIMIT $limit
                              ")
                    ->result();
  }

}
