<?php $row = $this->model->get_where("tb_member",["id_member"=>$this->session->userdata("id_member")]);

  $total_referral = $this->db->query("SELECT
                    tb_member.id_member,
                    tb_member.referral_from,
                    tb_member.kode_referral,
                    tb_member.is_verifikasi
                    FROM
                    tb_member
                    WHERE
                    tb_member.referral_from = '$row->kode_referral' AND
                    tb_member.is_verifikasi = '1'
                    ")->num_rows();
?>

<div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-5 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Hi,<?=$row->nama?></h4>
                </div>
                <div class="col-12 col-xl-7">
                  <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div class="border-right pr-4 mb-3 mb-xl-0">
                      <p class="text-muted">Mulai Bergabung </p>
                      <h4 class="mb-0 font-weight-bold"><?=date("d/m/Y",strtotime($row->created))?></h4>
                    </div>
                    <div class="border-right pr-4 mb-3 mb-xl-0">
                      <p class="text-muted">Kode Refferal</p>
                      <h4 class="mb-0 font-weight-bold"><?=$row->kode_referral?></h4>
                    </div>
                    <div class="pr-4 mb-3 mb-xl-0">
                      <p class="text-muted">Jumlah Referral</p>
                      <h4 class="mb-0 font-weight-bold"><?=$total_referral?> Orang</h4>
                    </div>
                    <!-- <div class="pr-3 mb-3 mb-xl-0">
                      <p class="text-muted">Referral From</p>
                      <h4 class="mb-0 font-weight-bold"><?=$row->referral_from?></h4>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
