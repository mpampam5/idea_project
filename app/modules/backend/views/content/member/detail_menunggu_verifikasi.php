<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="<?=site_url("backend/index")?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?=site_url("backend/member/menunggu_verifikasi")?>"><?=$title?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?=$button?></li>
  </ol>
</nav>

<div class="row">
  <div class="col-12">
    <div class="alert alert-primary" role="alert">
        <b><?=ucfirst($row->nama)?></b> menunggu anda untuk memverifikasi sebagai mitra.
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 stretch-card">

    <div class="card">
      <div class="card-body">

          <h4 class="card-title"><?=$button?> <?=$title?></h4>

        <hr>

          <div class="col-sm-12 table-responsive">
            <table id="table" class="table table-bordered">
              <tr>
                <td colspan="2" class="bg-primary text-white"><h5>Data Personal</h5></td>
              </tr>

              <tr>
                <td>Waktu Registrasi</td>
                <td><?=date("d/m/Y",strtotime($row->created))?></td>
              </tr>

              <tr>
                <td>Jenis Paket</td>
                <td><?=$row->paket?></td>
              </tr>

              <tr>
                <td>Nama</td>
                <td><?=$row->nama?></td>
              </tr>

              <tr>
                <td>Email</td>
                <td><?=$row->email?></td>
              </tr>

              <tr>
                <td>Telepon</td>
                <td><?=$row->telepon?></td>
              </tr>

              <tr>
                <td>Tempat,Tgl Lahir</td>
                <td><?=$row->tempat_lahir?>,&nbsp; <?=date("d-m-Y",strtotime($row->tgl_lahir))?></td>
              </tr>

              <tr>
                <td>Jenis Kelamin</td>
                <td><?=$row->jk?></td>
              </tr>

              <tr>
                <td>Provinsi</td>
                <td><b><?=wilayah_indonesia("wil_provinsi", ["id"=>$row->provinsi]);?></b></td>
              </tr>

              <tr>
                <td>Kabupaten/Kota</td>
                <td><b><?=wilayah_indonesia("wil_kabupaten",["id"=>$row->kabupaten]);?></b></td>
              </tr>

              <tr>
                <td>Kecamatan</td>
                <td><b><?=wilayah_indonesia("wil_kecamatan",["id"=>$row->kecamatan]);?></b></td>
              </tr>

              <tr>
                <td>Kelurahan/Desa</td>
                <td><b><?=wilayah_indonesia("wil_kelurahan",["id"=>$row->kelurahan]);?></b></td>
              </tr>



              <tr>
                <td>Alamat Lengkap</td>
                <td><?=$row->alamat?></td>
              </tr>

              <tr>
                <td colspan="2" class="bg-primary text-white"><h5>Data Rekening</h5></td>
              </tr>

              <tr>
                <td>BANK</td>
                <td><?=$row->bank?></td>
              </tr>

              <tr>
                <td>No.Rekening</td>
                <td><?=$row->no_rekening?></td>
              </tr>

              <tr>
                <td>Nama Rekening</td>
                <td><?=$row->nama_rekening?></td>
              </tr>

              <tr>
                <td>Kota Pembukaan Rekening</td>
                <td><?=$row->kota_pembukaan_rekening?></td>
              </tr>

              <tr>
                <td colspan="2" class="bg-primary text-white"><h5>Data Akun</h5></td>
              </tr>

              <tr>
                <td>Username</td>
                <td><?=$row->username?></td>
              </tr>

              <tr>
                <td>Kode Referral</td>
                <td class="text-info"><?=$row->kode_referral?></td>
              </tr>

              <tr>
                <td>Link Referral</td>
                <td>
                  <a href="<?=site_url("referral/$row->kode_referral")?>" target="_blank"><?=site_url("referral/$row->kode_referral")?></a>
                </td>
              </tr>

              <tr>
                <td colspan="2">
                  <a href="<?=site_url("backend/member/menunggu_verifikasi")?>" class="btn btn-secondary text-white btn-sm"> Kembali</a>
                  <a href="<?=site_url("backend/pohon_jaringan/verifikasi_member/$row->id_member")?>" id="verifikasi" class="btn btn-success btn-sm"> Verifikasi</a>
                  <a href="#" id="hapus" class="btn btn-danger btn-sm"> Hapus</a>
                </td>
              </tr>

            </table>
          </div>

      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$(document).on("click","#delete",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('Konfirmasi Hapus');
  $('#modalContent').html(`<p>Apakah anda yakin ingin menghapus?</p>`);
  $('#modalFooter').addClass('modal-footer').html(`<button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=`+$(this).attr('alt')+`  data-url=`+$(this).attr('href')+`>Ya, saya yakin</button>
                                                  <button type='button' class='btn btn-light btn-sm' data-dismiss='modal'>Batal</button>

                        `);
  $("#modalGue").modal('show');
});

$(document).on('click','#ya-hapus',function(e){
  $(this).prop('disabled',true)
          .text('Memproses...');
  $.ajax({
          url:$(this).data('url'),
          type:'post',
          cache:false,
          dataType:'json',
          success:function(json){
            $('#modalGue').modal('hide');
            $.toast({
              text: json.alert,
              showHideTransition: 'slide',
              icon: json.success,
              loaderBg: '#f96868',
              position: 'bottom-right',
              afterHidden: function () {
                  $('#table').DataTable().ajax.reload();
              }
            });


          }
        });
});


$(document).on("click","#verifikasi",function(e){
  e.preventDefault();
  $('.modal-dialog').removeClass('modal-lg')
                    .removeClass('modal-md')
                    .addClass('modal-sm');
  $("#modalTitle").text('Konfirmasi Verifikasi Member');
  $('#modalContent').html(`<p>Apakah anda yakin ingin Verifikasi?</p>`);
  $('#modalFooter').addClass('modal-footer').html(`<a  class='btn btn-success btn-sm'  href=`+$(this).attr('href')+`>Ya, saya yakin</a>
                                                    <button type='button' class='btn btn-light btn-sm' data-dismiss='modal'>Batal</button>
                                                    `);
  $("#modalGue").modal('show');
});
</script>
