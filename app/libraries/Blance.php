<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Blance {


function deposit($id_member){

  $ci =& get_instance();
  $query = $ci->db->select(" trans_member_deposit.id_deposit,
                              trans_member_deposit.id_member,
                              SUM(trans_member_deposit.nominal) AS nominal,
                              trans_member_deposit.keterangan,
                              trans_member_deposit.status,
                              tb_member.nama
                              ")
                              ->from('trans_member_deposit')
                              ->join("tb_member","trans_member_deposit.id_member = tb_member.id_member")
                              ->where("trans_member_deposit.status","verifikasi")
                              ->where("trans_member_deposit.id_member",$id_member)
                              ->get()
                              ->row();
  return $query->nominal;
}









} //END DEPOSIT
