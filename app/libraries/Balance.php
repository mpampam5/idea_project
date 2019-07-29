<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Balance {


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



function withdraw($id_member){

  $ci =& get_instance();
  $query = $ci->db->select(" trans_member_withdraw.id_withdraw,
                              trans_member_withdraw.id_member,
                              SUM(trans_member_withdraw.nominal) AS nominal,
                              trans_member_withdraw.keterangan,
                              trans_member_withdraw.status,
                              tb_member.nama
                              ")
                              ->from('trans_member_withdraw')
                              ->join("tb_member","trans_member_withdraw.id_member = tb_member.id_member")
                              ->where("trans_member_withdraw.status","verifikasi")
                              ->where("trans_member_withdraw.id_member",$id_member)
                              ->get()
                              ->row();
  return $query->nominal;
}


function total_balance($id_member)
{
  $ci =& get_instance();

  $deposit  = $this->deposit($id_member);
  $withdraw = $this->withdraw($id_member);

  $balance = $deposit - $withdraw;
  return $balance;
}









} //END DEPOSIT
