<div class="row mb-4">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-5">
            <div class="col-12 col-xl-5 mb-4 mb-xl-0">
                  <h4 class="font-weight-bold">Hi, Welcome!</h4>
                  <h4 class="font-weight-normal mb-0"><?=profile("nama")?></h4>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" id="copy-referral" placeholder="Link Referral" aria-label="Link Referral" value="<?=site_url("referral/".profile("kode_referral"))?>" readonly>
                <div class="input-group-append">
                  <button class="btn btn-sm btn-primary btn-clipboard" type="button" data-clipboard-action="copy" data-clipboard-target="#copy-referral">Copy Link Referral</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">

  <div class="offset-md-2 col-md-4 grid-margin stretch-card">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Deposit</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rp. <?=format_rupiah($deposit)?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Withdraw</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rp. <?=format_rupiah($withdraw)?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-success text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Balance</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rp. <?=format_rupiah($balance)?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-success text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Comission</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rp. <?=format_rupiah($this->balance->sponsor(sess('id_member')))?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-success text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Status Stockis</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Gold</h3>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Referral lansung</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0 Orang</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Group Left</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0 Orang</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-danger text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Group Right</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0 Orang</h3>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-info text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">Stock PIN</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?=$this->balance->stok_pin(sess('id_member'))?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-info text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">PIN Terpakai</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?=$this->balance->cek_pin_terpakai(sess('id_member'))?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-info text-white">
      <div class="card-body">
        <p class="card-title text-md-center text-xl-left text-white">PIN Order</p>
        <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
          <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0</h3>
        </div>
      </div>
    </div>
  </div>


</div>
