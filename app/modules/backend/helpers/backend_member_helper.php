<?php defined('BASEPATH') OR exit('No direct script access allowed');

function wilayah_indonesia($table,$where){

  $ci = get_instance();
  $query =  $ci->db->get_where($table,$where);
  if ($query->num_rows() > 0) {
      return $query->row()->name;
  }else {
    return "data wilayah tidak di temukan";
  }

}

// Menampilkan datamember berdasarkan id dan field yang ingin di tampilkan
function profile_member($id_member,$field)
{
  $ci = get_instance();
  $query =  $ci->db->get_where("tb_member",["id_member"=>$id_member]);
  if ($query->num_rows() > 0) {
      return $query->row()->$field;
  }else {
    return "data member tidak di temukan";
  }
}
