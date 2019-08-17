<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Contoh extends MY_Controller{


  // public $all_id_child = array();

  public $is_parent = array();



  public function __construct()
  {
    parent::__construct();
    $this->load->library(array("btree","coba"));
  }


  function get($id)
  {
    $data = [];
    $is_parent = $this->btree->cek_is_parent($id);

      foreach ($is_parent as $value) {
        $data[$value]= $this->pairing($value);
      }

    echo json_encode($data);
  }


  // function add_pairing($id)
  // {
  //   $left ['kiri']= $this->btree->get_left_id_children($id);
  //   $right ['kanan']= $this->btree->get_right_id_children($id);
  //
  //   $data = array($left,$right );
  //
  //   return $data;
  // }





function pairing($id)
{

    $pin_left = [];
    $pin_right = [];


    $left = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($this->btree->get_left_id_children($id))), 0);

    foreach ($left as $id_left) {
      $pin_left[ ]= paket(profile_member($id_left,'paket'),'pin');
    }

    $right = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($this->btree->get_right_id_children($id))), 0);
    foreach ($right as $id_right) {
      $pin_right[]= paket(profile_member($id_right,'paket'),'pin');
    }

    $total_l = array_sum($pin_left) * config_all('harga_pin');
    $total_r = array_sum($pin_right) * config_all('harga_pin');

    if ($total_l<=$total_r) {
      $total = (config_all('komisi_pairing')/100) * $total_l;
    }else {
      $total = (config_all('komisi_pairing')/100) * $total_r;
    }

    // if ($total!=0) {
    //   $insert = array('id_member'=>$id,"total_bonus"=>$total,"created"=>date("Y-m-d h:i:s"));
    //   $this->db->insert('bonus_pairing',$insert);
    // }

    $pin = array($left,$right);

    // echo json_encode($pin);
  return $pin;
}


//
//
// function get_right_id_children($id){ //Function get id right children
//
//   $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
//   $right_child=[];
//
//   if(!empty($array->r_mem)) {
//       array_push($right_child, $array->r_mem);
//       $right_child[]= $this->all_id_child($array->r_mem);
//   }
//
//   return $right_child;
// }
//
//
//
//
// function get_left_id_children($id){ //Function get id left children
//
//   $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
//   $left_child=[];
//
//   if(!empty($array->l_mem)) {
//       array_push($left_child, $array->l_mem);
//       $left_child[]= $this->all_id_child($array->l_mem);
//   }
//
//   return $left_child;
// }
//
//
//
// function all_id_child($id) { //Function get id all children
//
//     $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
//     $all_id_child = [];
//     if(!empty($array->r_mem)) {
//         array_push($all_id_child, $array->r_mem);
//         $all_id_child[]= $this->all_id_child($array->r_mem);
//     }
//
//     if(!empty($array->l_mem)) {
//         array_push($all_id_child, $array->l_mem);
//         $all_id_child[]= $this->all_id_child($array->l_mem);
//     }
//
//     return array_values($all_id_child);
// }
//





  function cek_is_parent($id)
  {
    $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();

    if($array->id_parent!=0) {
        array_push($this->is_parent, $array->id_parent);
        $is_parent[]= $this->cek_is_parent($array->id_parent);
    }

    return array_filter($this->is_parent);
  }




  function prints()
  {
    $this->load->view("content/contoh/print");
  }

  function cetak($id)
  {
    $data['cetak'] =  $this->db->get_where("config_bank",["id_rekening"=>$id])->row();
    $this->load->view("content/contoh/cetak",$data);
  }



} //end class contoh
