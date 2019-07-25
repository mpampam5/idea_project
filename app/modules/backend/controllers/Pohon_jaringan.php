<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."/modules/backend/core/MY_Controller.php";

class Pohon_jaringan extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model('Pohon_model','model');
  }

  function index(){
    $this->load->helper(['cek_pohon']);
    $this->template->set_title("Pohon Jaringan");
    $data["root"] = $this->model->get_where("tb_member",["id_member"=>$this->session->userdata("id_member")]);
    $this->template->view("content/pohon_jaringan/index",$data);
  }


  function show($id)
  {
    $this->load->helper(['cek_pohon']);
    $this->template->set_title("Pohon Jaringan");
    $data["root"] = $this->model->get_where("tb_member",["id_member"=>$id]);
    $this->template->view("content/pohon_jaringan/index",$data);
  }


  function tambah($id_parent="",$posisi="")
  {
      if ($id_parent=="" OR $posisi=="") {
        $this->_error404();
        }else {
        $this->template->set_title("Pohon Jaringan");
        $data["provinsi"] = $this->db->get("wil_provinsi")->result();
        $data["bank"]   = $this->db->get("ref_bank")->result();
        $data['id_parent'] = $id_parent;
        $data['posisi'] = $posisi;
        $this->template->view("content/pohon_jaringan/form",$data);
      }
  }

  function _rules()
  {
    $this->form_validation->set_rules("kode_referal","Kode Referral","trim|xss_clean|required|callback__cek_kode_ref",[
      "required" => "Silahkan masukkan kode referal mitra anda."
    ]);


    $this->form_validation->set_rules("id_parent","id_parent","trim|xss_clean|required");
    $this->form_validation->set_rules("posisi","posisi","trim|xss_clean|required");
    $this->form_validation->set_rules("nama","Nama","trim|xss_clean|required");
    $this->form_validation->set_rules("email","Email","trim|xss_clean|valid_email");
    $this->form_validation->set_rules("telepon","Telepon","trim|xss_clean|numeric");

    $this->form_validation->set_rules("tempat_lahir","Tempat Lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("tgl_lahir","Tanggal Lahir","trim|xss_clean|required");
    $this->form_validation->set_rules("jk","Jenis Kelamin","trim|xss_clean|required");
    $this->form_validation->set_rules("provinsi","Provinsi","trim|xss_clean|required");
    $this->form_validation->set_rules("kabupaten","Kabupaten/Kota","trim|xss_clean|required");
    $this->form_validation->set_rules("kecamatan","Kecamatan","trim|xss_clean|required");
    $this->form_validation->set_rules("kelurahan","Kelurahan/Desa","trim|xss_clean|required");
    $this->form_validation->set_rules("alamat","Alamat Lengkap","trim|xss_clean|required");
    $this->form_validation->set_rules("paket","Jenis Paket","trim|xss_clean|required");
    $this->form_validation->set_rules("bank","Jenis Bank","trim|xss_clean|required");
    $this->form_validation->set_rules("no_rek","NO.rekening","trim|xss_clean|required|numeric");
    $this->form_validation->set_rules("nama_rekening","Nama Rekening","trim|xss_clean|required");
    $this->form_validation->set_rules("kota_pembukaan_rek","Kota/Kabupaten Pembukaan Rekening","trim|xss_clean");
    $this->form_validation->set_rules("username","Username","trim|xss_clean|required|alpha_dash|is_unique[tb_auth.username]",[
      "is_unique" => "Coba Username yang lain"
    ]);
    $this->form_validation->set_rules("password","Password","trim|xss_clean|required|min_length[5]");
    $this->form_validation->set_rules("v_password","Konfirmasi Password","trim|xss_clean|required|matches[password]");
    $this->form_validation->set_error_delimiters('<label class="error mt-2 text-danger">','</label>');
  }

  function tambah_action(){
    if ($this->input->is_ajax_request()) {
        $json = array('success'=>false, 'alert'=>array());
        $this->load->library(array("form_validation"));

        $kode_referral      = $this->input->post("kode_referal",true);
        $nik                = $this->input->post("nik",true);
        $nama               = $this->input->post("nama",true);
        $email              = $this->input->post("email",true);
        $telepon            = $this->input->post("telepon",true);
        $tempat_lahir       = $this->input->post("tempat_lahir",true);
        $tgl_lahir          = $this->input->post("tgl_lahir",true);
        $jk                 = $this->input->post("jk",true);
        $provinsi           = $this->input->post("provinsi",true);
        $kabupaten          = $this->input->post("kabupaten",true);
        $kecamatan          = $this->input->post("kecamatan",true);
        $kelurahan          = $this->input->post("kelurahan",true);
        $alamat             = $this->input->post("alamat",true);
        $paket              = $this->input->post("paket",true);
        $bank               = $this->input->post("bank",true);
        $no_rek             = $this->input->post("no_rek",true);
        $nama_rekening      = $this->input->post("nama_rekening",true);
        $kota_pembukaan_rek = $this->input->post("kota_pembukaan_rek",true);
        $username           = $this->input->post("username",true);
        $password           = $this->input->post("password",true);


        $id_parent = $this->input->post("id_parent");
        $posisi = $this->input->post("posisi");

        $this->form_validation->set_rules("nik","Nik/No.KTP","trim|xss_clean|required|min_length[16]|max_length[16]|numeric|callback__cek_nik[".$tgl_lahir."]|is_unique[tb_member.nik]",[
          "is_unique" => "Nik/No.KTP sudah terdaftar"
        ]);

        $this->_rules();
        if ($this->form_validation->run()) {


            $insert_member = [  "kode_referral" => "ref_$username",
                                "referral_from" => $kode_referral ,
                                "nik"           => $nik,
                                "nama"          => $nama,
                                "telepon"       => $telepon,
                                "email"         => $email,
                                "jk"            => $jk,
                                "tempat_lahir"  => $tempat_lahir,
                                "tgl_lahir"     => date("Y-m-d",strtotime($tgl_lahir)),
                                "provinsi"      => $provinsi,
                                "kabupaten"     => $kabupaten,
                                "kecamatan"     => $kecamatan,
                                "kelurahan"     => $kelurahan,
                                "alamat"        => $alamat,
                                "paket"         => $paket,
                                "is_verifikasi" => "1",
                                "posisi"        => $posisi,
                                "created"       => date("Y-m-d h:i:s"),
                            ];
          // insert member
          $this->model->get_insert("tb_member",$insert_member);

          $last_id_member = $this->db->insert_id();

          $insert_data_bank = [ "id_member"                =>  $last_id_member,
                                "id_bank"                  =>  $bank,
                                "no_rekening"              =>  $no_rek,
                                "nama_rekening"            =>  $nama_rekening,
                                "kota_pembukaan_rekening"  =>  $kota_pembukaan_rek
                              ];
          // insert data bank
          $this->model->get_insert("trans_member_rek",$insert_data_bank);

          $this->load->helper("pass_hash");

          $data_akun = [  "id_personal"  =>  $last_id_member,
                          "username"     =>  $username,
                          "password"     =>  pass_encrypt(date("dmYhis"),$password),
                          "token"        =>  date("dmYhis"),
                          "level"        =>  "member",
                          "created"      =>  date("Y-m-d h:i:s")
                        ];
          // insert data auth
          $this->model->get_insert("tb_auth",$data_akun);

          $trans_member = [ "id_parent" => $id_parent,
                            "id_member" => $last_id_member
                          ];

          $this->model->get_insert("trans_member",$trans_member);

          $json['alert'] = "Berhasil melakukan menambahkan member";
          $json['success'] = true;
          $json['url'] = site_url("backend/pohon_jaringan");
        }else {
          foreach ($_POST as $key => $value)
            {
              $json['alert'][$key] = form_error($key);
            }
        }

      echo json_encode($json);
    }
  }


  function _cek_kode_ref($str)
  {
      $qry = $this->db->get_where("tb_member",["kode_referral"=>$str, "is_verifikasi"=>"1"]);
      if ($qry->num_rows() > 0) {
        return true;
      }else {
        $this->form_validation->set_message('_cek_kode_ref', 'Kode referal yang anda masukkan tidak terdaftar');
        return false;
      }

  }


function _cek_nik($str,$tgl_lahir)
{
  if ($tgl_lahir!="") {
    $tgl_array = explode("/",$tgl_lahir);
    $tgl = $tgl_array[0];
    $bulan = $tgl_array[1];
    $tahun = substr($tgl_array[2],-2);

    $gabung = $tgl."".$bulan."".$tahun;
    $nik = substr($str,-10,-4);
    if ($gabung==$nik) {
        return true;
    }else {
        $this->form_validation->set_message('_cek_nik', 'Nik/No.KTP tidak valid.');
        return false;
    }
  }else {
    return true;
  }

}




function kabupaten(){
      $propinsiID = $_GET['id'];
      $kabupaten   = $this->db->get_where('wil_kabupaten',array('province_id'=>$propinsiID));
      echo '<option value="">-- Pilih Kabupaten/Kota --</option>';
      foreach ($kabupaten->result() as $k)
      {
          echo "<option value='$k->id'>$k->name</option>";
      }
  }


  function kecamatan(){
     $kabupatenID = $_GET['id'];
     $kecamatan   = $this->db->get_where('wil_kecamatan',array('regency_id'=>$kabupatenID));
     echo '<option value="">-- Pilih Kecamatan --</option>';
     foreach ($kecamatan->result() as $k)
     {
         echo "<option value='$k->id'>$k->name</option>";
     }
 }

 function kelurahan(){
      $kecamatanID  = $_GET['id'];
      $desa         = $this->db->get_where('wil_kelurahan',array('district_id'=>$kecamatanID));
      echo '<option value="">-- Pilih Kelurahan/Desa --</option>';
      foreach ($desa->result() as $d)
      {
          echo "<option value='$d->id'>$d->name</option>";
      }
  }


  ///END REGISTER FORM MEMBER


  ///member
  function verifikasi_member($id_member=""){
    if ($id_member!="") {
      // cek apakah id member sudah terverifikasi
      //jika sudah tidak bisa mengakses modul member verifikasi
      $qry = $this->db->get_where("tb_member",["id_member"=>$id_member,"is_verifikasi"=>"1"]);
      if ($qry->num_rows() > 0) {
          redirect(site_url("backend/pohon_jaringan/show/$id_member"),"refresh");
      }else {
        $this->load->helper(['cek_pohon_verif']);
        $this->template->set_title("Verifikasi Member");
        $data["id_member_verif"] = $id_member;
        $data["root"] = $this->model->get_where("tb_member",["id_member"=>$this->session->userdata("id_member")]);
        $this->template->view("content/pohon_jaringan/index_posisi_member",$data);
      }
    }else {
      $this->_error404();
    }
  }

  function verifikasi_member_action($id_parent,$posisi,$id_member_verif){
    if ($this->input->is_ajax_request()) {

      $update_member = [ "is_verifikasi" =>"1",
                         "posisi" => $posisi,
                         "created" => date("Y-m-d h:i:s")
                        ];
      $this->model->get_update("tb_member",$update_member,["id_member"=>$id_member_verif]);

      $insert_trans_parent = [ "id_parent"=>$id_parent,
                                "id_member"=>$id_member_verif
                            ];
      $this->model->get_insert("trans_member",$insert_trans_parent);
      $json['alert'] = "Member berhasil di verifikasi";
      $json['url']  = site_url("backend/pohon_jaringan/show/$id_parent");

      echo json_encode($json);
    }
  }



} //end class
