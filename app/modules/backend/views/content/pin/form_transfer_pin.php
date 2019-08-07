<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="<?=site_url("backend/index")?>">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Transaksi PIN</li>
    <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($title)?></li>
  </ol>
</nav>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"> <?=$title?></h4>
        <hr>


          <form class="" action="index.html" id="form" autocomplete="off">
            <div class="form-group">
              <label for="">Username Pengguna</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Masukkan Usename Penerima" id="val_username" name="username">
                <div class="input-group-append">
                  <button class="btn btn-sm btn-primary" type="button" id="cek_username">Cek Username</button>
                </div>
              </div>
              <div id="username"></div>
            </div>

            <div class="form-group">
              <label for="">Nama</label>
              <input type="text" class="form-control" id="nama" readonly>
            </div>

            <div class="form-group">
              <label for="">No. Telepon</label>
              <input type="text" class="form-control" id="telepon" readonly>
            </div>

            <div class="form-group">
              <label for="">Jumlah PIN yang ingin di transfer</label>
              <input type="text" class="form-control" id="jumlah_pin" name="jumlah_pin" placeholder="Jumlah PIN">
            </div>

            <div class="form-group">
              <label for="">Password Verifikasi</label>
              <input type="text" class="form-control" id="password" name="password" placeholder="Password Verifikasi">
            </div>

            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-sm"> Transfer PIN</button>
          </form>

      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


$(document).on("click","#cek_username",function(e){
  e.preventDefault();
  $("#cek_username").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Memproses...');
  var username = $("#val_username").val();
   if (username==="") {
     $("#nama").val('');
     $("#telepon").val('');
     $("#cek_username").prop('disabled',false).html('Cek Username');
     $("#username").html('<label class="error mt-2 text-danger">Username tidak boleh kosong.</label>');
   }else {
     $("#cek_username").prop('disabled',false).html('Cek Username');
    $("#username").html('');
    $.ajax({
            url:"<?=site_url("backend/pin/transfer_pin_cek_usename")?>",
            type:'post',
            cache:false,
            data:{'username':username},
            dataType:'json',
            success:function(json){
              if (json.success==true) {
                $("#nama").val(json.nama);
                $("#telepon").val(json.telepon);
              }else {
                $("#nama").val('');
                $("#telepon").val('');
                $("#username").html('<label class="error mt-2 text-danger"><i class="fa fa-close"></i>'+json.alert+'</label>');
              }


            }
          });
   }
})

$("#form").submit(function(e){
  e.preventDefault();
  var me = $(this);
  $("#submit").prop('disabled',true).html('<div class="spinner-border spinner-border-sm text-white"></div> Memproses...');
  $.ajax({
        url             : me.attr('action'),
        type            : 'post',
        data            :  new FormData(this),
        contentType     : false,
        cache           : false,
        dataType        : 'JSON',
        processData     :false,
        success:function(json){
          if (json.success==true) {
              $('.form-group').removeClass('.has-error')
                              .removeClass('.has');
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right'
              });


          }else {
            $("#submit").prop('disabled',false)
                        .html('Transfer PIN');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
              .closest('.form-group')
              .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
  });
});









</script>
