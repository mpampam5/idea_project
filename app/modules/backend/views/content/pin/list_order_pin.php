<link rel="stylesheet" href="<?=base_url()?>_template/back/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
<script src="<?=base_url()?>_template/back/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?=base_url()?>_template/back/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="<?=site_url("backend/index")?>">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Transaksi PIN</li>
    <li class="breadcrumb-item active" aria-current="page"><?=$title?></li>
  </ol>
</nav>


<div class="row">
  <div class="col-12 stretch-card">

    <div class="card">
      <div class="card-body">
          <h4 class="card-title"> <?=$title?></h4>
          <div class="btn-group-header">
            <a href="#" class="btn btn-primary btn-sm btn-icon-text" id="table-reload"> <i class="fa fa-refresh btn-icon-prepend"></i></a>
          </div>

        <hr>

            <table id="table" class="table table-bordered" style="width:100%">
              <thead>
                <tr class="bg-warning text-white">
                    <th width="10px">#</th>
                    <th>Waktu Order</th>
                    <th>Jumlah PIN</th>
                    <th>Jumlah Bayar</th>
                    <th>Jenis Bayar</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
              </thead>

            </table>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
      var t = $("#table").dataTable({
          initComplete: function() {

            $(document).on('click', '#table-reload', function(){
                api.search('').draw();
                $('#table_filter input').val('');
              });

              var api = this.api();
              $('#table_filter input')
                      .off('.DT')
                      .on('keyup.DT', function(e) {
                          if (e.keyCode == 13) {
                              api.search(this.value).draw();
                  }
              });
          },
          oLanguage: {
              sProcessing: "Memuat Data..."
          },
          processing: true,
          serverSide: true,
          responsive:true,
          ajax: {"url": "<?=base_url()?>backend/pin/json_list_order_pin", "type": "POST"},
          columns: [
              {
                "data": "id_order_pin",
                "orderable": false,
                "visible":false
              },
              {"data":"tgl_order"},
              {"data":"jumlah_pin",
                "class":"text-center"
              },
              {"data":"jumlah_bayar",
                render: function(data, type, row, meta){
                  return 'Rp. '+data;
                }
              },
              {"data":"sumber_dana",
                render : function(data, type, row, meta){
                  if (data=="balance") {
                    var str = `Pembelian Lansung Menggunakan Balance`;
                  }else {
                    var str = `Tansfer Melalui <b>`+row.bank+`</b> | AN : <b>`+row.nama_rekening+`</b>`;
                  }

                  return '<p>'+str+'</p>';
                }

              },
              {"data":"status",
                render:function(data,type,row,meta)
                {
                  if (data=="approved") {
                      return '<span class="badge badge-pill badge-success"> Approved</span>';
                  }else {
                      return '<span class="badge badge-pill badge-danger"> Pending</span>';
                  }
                }
              },
              {"data":"nama_rekening","visible":false},
              {"data":"bank","visible":false},

          ],
          order: [[0, 'desc']],
      });
});






</script>
