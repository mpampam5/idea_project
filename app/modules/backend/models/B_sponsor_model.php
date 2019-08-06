<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Model.php";

class B_sponsor_model extends MY_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function json()
  {
    $this->datatables->select("bonus_sponsor.id_bonus_sponsor,
                                bonus_sponsor.id_parent,
                                bonus_sponsor.id_member,
                                format(bonus_sponsor.total_bonus,2) AS total_bonus,
                                bonus_sponsor.created");
    $this->datatables->from('bonus_sponsor');
    $this->datatables->where('bonus_sponsor.id_parent',sess('id_member'));
    return $this->datatables->generate();
  }


}
