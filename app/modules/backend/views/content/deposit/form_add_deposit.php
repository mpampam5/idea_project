  <form action="<?=site_url("backend/deposit/action_add_deposit")?>" id="form" autocomplete="off">
    <p>Silahkan Masukkan Nominal Deposit anda.</p>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="">Ammount (Rp)</label>
            <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Ammount">
          </div>
        </div>

        <!-- <div class="col-sm-12">
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea  class="form-control" name="keterangan" id="keterangan" rows="3" cols="80" placeholder="Keterangan"></textarea>
          </div>
        </div> -->

        <div class="col-sm-12">
          <div class="form-group">
            <label for="">Password verifikasi</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
        </div>

        <div class="col-sm-12">
          <button type='button' class='btn btn-secondary btn-md text-white' data-dismiss='modal'>Batal</button>
          <button type="submit" id="submit" name="submit" class="btn btn-primary btn-md"> DEPOSIT</button>
        </div>

    </div>
  </form>


<script type="text/javascript">
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
              $('#table').DataTable().ajax.reload();
              $("#modalGue").modal('hide');
              $('.form-group').removeClass('.has-error')
                              .removeClass('.has');
              $.toast({
                text: json.alert,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'bottom-right',
              });


          }else {
            $("#submit").prop('disabled',false)
                        .html('DEPOSIT');
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
