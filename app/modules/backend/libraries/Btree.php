<?php

  /**
   *
   */
  class Btree
  {


private $ci;

public $data = array();

  // function index()
  // {
  //
  //     // $query = $this->db->get_where("contoh",['id_member'=>1])->row();
  //     echo "Left Child ".$this->leftcount(1)."</br>";
  //     echo "Right Child ".$this->rightcount(1)."</br>";
  //     echo "All Child ".$this->allcount(1)."</br>";
  // }


      public function __construct()
        {
          $this->ci =& get_instance();
        }

      function leftcount($id)   //Function to calculate all right children count
        {
          $array = $this->ci->db->get_where("trans_member",['id_member'=>$id])->row_array();
          $count = 0;
          if(!empty($array['l_mem']))
          {
              $count+= $this->allcount($array['l_mem'])+1;
          }
          return $count;
        }

      function rightcount($id)   //Function to calculate all right children count
        {
            $array = $this->ci->db->get_where("trans_member",['id_member'=>$id])->row_array();
            $count = 0;
            if(!empty($array['r_mem']))
            {
                $count+= ($this->allcount($array['r_mem'])+1);
            }
            return $count;
        }


      function allcount($id)   //Function to calculate all children count
        {
          $array = $this->ci->db->get_where("trans_member",['id_member'=>$id])->row_array();
            // $array = array_count_values($array);
          $count = 0;
          if(!empty($array['r_mem']))
          {
              $count+=($this->allcount($array['r_mem'])+1);
          }
          if(!empty($array['l_mem']))
          {
              $count+=($this->allcount($array['l_mem'])+1);
          }
          return $count;
        }








          function get_all_id_children($id) { //Function get id all children

            // $data = array();
              $array = $this->ci->db->get_where("trans_member",['id_member'=>$id])->row();

              if(!empty($array->r_mem)) {
                  array_push($this->data, $array->r_mem);
                  // $data[]=$array->r_mem;
                  $data[]= $this->get_all_id_children($array->r_mem);
              }

              if(!empty($array->l_mem)) {
                  array_push($this->data, $array->l_mem);
                  // $data[] = $array->l_mem;
                  $data[]= $this->get_all_id_children($array->l_mem);
              }

              return array_filter($this->data);
          }



} //end class
