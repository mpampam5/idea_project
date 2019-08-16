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
    $is_parent = $this->btree->cek_is_parent($id);

      foreach ($is_parent as $value) {
        $data[$value]= $this->add_pairing($value);
      }

    echo json_encode($data);
  }


  function add_pairing($id)
  {
    $left = $this->btree->get_left_id_children($id);
    $right = $this->btree->get_right_id_children($id);

    $data = array($left ,$right );

    return $data;
  }





function pairing($id)
{
  $btree =[];
  $id =  $this->cek_is_parent($id);
  //
  //
  foreach ($id as $ids) {
    $btree[$ids][] = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($this->get_left_id_children($ids))), 0);

    $btree[$ids][] = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($this->get_right_id_children($ids))), 0);
  }


  echo json_encode($btree);
}




function get_right_id_children($id){ //Function get id right children

  $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
  $right_child=[];

  if(!empty($array->r_mem)) {
      array_push($right_child, $array->r_mem);
      $right_child[]= $this->all_id_child($array->r_mem);
  }

  return $right_child;
}




function get_left_id_children($id){ //Function get id left children

  $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
  $left_child=[];

  if(!empty($array->l_mem)) {
      array_push($left_child, $array->l_mem);
      $left_child[]= $this->all_id_child($array->l_mem);
  }

  return $left_child;
}



function all_id_child($id) { //Function get id all children

    $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();
    $all_id_child = [];
    if(!empty($array->r_mem)) {
        array_push($all_id_child, $array->r_mem);
        $all_id_child[]= $this->all_id_child($array->r_mem);
    }

    if(!empty($array->l_mem)) {
        array_push($all_id_child, $array->l_mem);
        $all_id_child[]= $this->all_id_child($array->l_mem);
    }

    return array_values($all_id_child);
}






  function cek_is_parent($id)
  {
    $array = $this->db->get_where("trans_member",['id_member'=>$id])->row();

    if($array->id_parent!=0) {
        array_push($this->is_parent, $array->id_parent);
        $is_parent[]= $this->cek_is_parent($array->id_parent);
    }

    return array_filter($this->is_parent);
  }



} //end class contoh
