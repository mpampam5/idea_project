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
        <h4 class="card-title"> Form Beli PIN</h4>
        <hr>


          <form class="" action="index.html" method="post">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Jumlah PIN</label>
              <div class="col-sm-9">
                <div class="input-group jumlah_pin">
                  <input type="text" class="form-control" placeholder="Jumlah Pin" id="jumlah_pin" name="jumlah_pin">
                  <div class="input-group-append">
                    <span class="input-group-text text-primary">Harga Satuan PIN Rp. 150,000</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Stocklist Pembelian</label>
              <div class="col-sm-9">
                <select class="form-control" id="" name="" style="color:#000">
                  <option value="IDEA NETWORK">IDEA NETWORK</option>
                </select>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-sm-3 col-form-label"> Total Pembayaran</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="total_bayar" name="total_bayar" placeholder="Total Pembayaran" readonly>
              </div>
            </div>



            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Metode Pembayaran</label>
              <div class="col-sm-4">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sumber_dana" id="sumber_dana1" value="balance" checked>
                    &nbsp;Balance
                  <i class="input-helper"></i></label>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="sumber_dana" id="sumber_dana2" value="transfer">
                    &nbsp;Cash/Transfer Bank
                  <i class="input-helper"></i></label>
                </div>
              </div>
              <div id="sumber_dana"></div>
            </div>



            <div id="container_sumber_data"></div>



            <div class="offset-sm-3">
              <button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit"><i class="fa fa-shopping-cart"></i> BELI PIN</button>
            </div>


          </form>

      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).on("keyup","#jumlah_pin",function(e){
    e.preventDefault();
    var me = $(this).val();
    if (isNaN(me)) {
      $(".alert-pin").remove();
      $(".jumlah_pin").after('<p class="text-danger alert-pin"> Jumlah PIN hanya bisa berisi angka</p>')
      $("#total_bayar").val("");
    }else {
      var total = (me*150000);
      $("#total_bayar").val("Rp. "+parseInt(total).toLocaleString());
      $(".alert-pin").remove();
    }
  });




</script>
