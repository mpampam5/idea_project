<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Balance {

function total_balance($id_member)
  {
    $ci =& get_instance();

    $deposit       = $this->deposit($id_member);
    $withdraw      = $this->withdraw($id_member);
    $transaksi_pin = $this->total_transaksi_pin($id_member);

    //hitung
    $balance = $deposit - $withdraw - $transaksi_pin;
    return $balance;
  }



// menghitung jumlah deposit yang terverifikasi
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


//Menghitung total withdraw yang terverifikasi
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


// menghitung jumlah transaksi pin berdasarkan jumlah bayar menggunakan balance
function total_transaksi_pin($id_member)
{
  $ci =& get_instance();
  $query = $ci->db->select("trans_order_pin.id_order_pin,
                            trans_order_pin.id_member,
                            trans_order_pin.kode_transaksi,
                            SUM(trans_order_pin.jumlah_bayar) AS total,
                            trans_order_pin.sumber_dana,
                            trans_order_pin.id_config_bank,
                            trans_order_pin.tgl_order,
                            trans_order_pin.status")
                   ->from('trans_order_pin')
                   ->where("trans_order_pin.id_member",$id_member)
                   ->where("trans_order_pin.sumber_dana","balance")
                   ->get()
                   ->row();
  return $query->total;
}

// CEK STOK PIN
function stok_pin($id_member)
{
  $ci =& get_instance();
  $query = $ci->db->query("SELECT
                            trans_order_pin.id_order_pin,
                            trans_order_pin.id_member,
                            trans_order_pin.kode_transaksi,
                            trans_order_pin.status,
                            trans_pin.id_pin_trans,
                            trans_pin.kode_pin_trans,
                            trans_pin.status
                          FROM
                            trans_order_pin
                          INNER JOIN
                            trans_pin ON trans_pin.id_order_pin = trans_order_pin.id_order_pin
                          WHERE
                            trans_order_pin.status = 'approved'
                          AND
                            trans_pin.status = 'belum'
                          AND
                            trans_order_pin.id_member = $id_member")
                    ->num_rows();
  return $query ;
}

//CEK PIN TERPAKAI
function cek_pin_terpakai($id_member)
{
  $ci =& get_instance();
  $query = $ci->db->query("SELECT
                            trans_order_pin.id_order_pin,
                            trans_order_pin.id_member,
                            trans_order_pin.kode_transaksi,
                            trans_order_pin.status,
                            trans_pin.id_pin_trans,
                            trans_pin.kode_pin_trans,
                            trans_pin.status
                          FROM
                            trans_order_pin
                          INNER JOIN
                            trans_pin ON trans_pin.id_order_pin = trans_order_pin.id_order_pin
                          WHERE
                            trans_order_pin.status = 'approved'
                          AND
                            trans_pin.status = 'terpakai'
                          AND
                            trans_order_pin.id_member = $id_member")
                    ->num_rows();
  return $query ;
}


// CEK semua PIN
function cek_total_pin($id_member)
{
  $ci =& get_instance();
  $query = $ci->db->query("SELECT
                              trans_order_pin.id_order_pin,
                              trans_order_pin.id_member,
                              trans_order_pin.kode_transaksi,
                              trans_order_pin.status,
                              trans_pin.id_pin_trans
                            FROM
                              trans_order_pin
                            INNER JOIN
                              trans_pin ON trans_pin.id_order_pin = trans_order_pin.id_order_pin
                            WHERE
                              trans_order_pin.status = 'approved'
                            AND
                              trans_order_pin.id_member = $id_member")
                    ->num_rows();
  return $query ;
}





} //END DEPOSIT
