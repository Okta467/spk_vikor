<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Dusun - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('admin/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('admin/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('admin/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Dusun</a></li>
              </ul>
            </div>
            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-building"></i> Data Dusun</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <button class="btn btn-primary btn-sm toggle_modal_tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Daftar RT</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($dusuns->result() as $dusun) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $dusun->nama ?></td>
                          <td><?= $dusun->alamat ?></td>
                          <td>
                            <button class="btn btn-dark btn-sm toggle_modal_daftar_rt" data-dusun_id="<?= $dusun->id ?>">
                              <i class="fa fa-list"></i> Detail
                            </button>
                          </td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-dusun_id="<?= $dusun->id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-dusun_id="<?= $dusun->id ?>">
                                <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></button>
                              </span>
                            </div>
                          </td>
                        </tr>

                      <?php endforeach; ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      <!--//END CONTENT -->

      <!--============================== FOOTER ==============================-->
      <?php
      $this->load->view('admin/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <!--============================== MODAL DAFTAR RT ==============================-->
  <div class="modal fade" id="modal_daftar_rt" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-list"></i> Daftar RT</h4>
        </div>
        <div class="modal-body">

          <h4 id="modal_daftar_rt_title"></h4>

          <table class="table table-striped table-bordered jambo_table" id="modal_daftar_rt_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor RT</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!--//END DAFTAR RT -->

  <!--============================== MODAL TAMBAH/EDIT ==============================-->
  <div class="modal fade" id="modal_tambah_dan_edit" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
        </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal form-label-left" id="xform_modal_tambah_dan_edit">

            <!-- For updating data -->
            <input type="hidden" name="xdusun_id" id="xdusun_id">

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xnama">Nama Dusun</label>
              <input type="text" name="xnama" id="xnama" class="form-control" required="">
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xalamat">Alamat</label>
              <textarea name="xalamat" class="form-control" id="xalamat" style="resize: vertical" rows="3"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
        <!--/.form -->
      </div>
    </div>
  </div>
  <!--//END TAMBAH/EDIT -->

  <?php $this->load->view('admin/_partials/script') ?>

  <script>
    $(document).ready(function() {
      // Datatables initialise
      $('.datatables').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });
            
      var datatableModalDaftarRt = $('#modal_daftar_rt_table').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });

      $('.select2').select2({
        width: '100%'
      });


      $('.datatables').on('click', '.toggle_modal_daftar_rt', function () {
        const dusun_id = $(this).data('dusun_id');

        $.ajax({
          url: '<?= site_url('admin/dusun/get_all_rt') ?>',
          type: 'POST',
          data: {
            dusun_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_daftar_rt_title').html(data.dusun);

            // add datatables row
            let i = 1;
            let rowsData = [];

            for (key in data) {
              rowsData.push([i++, data[key]['rt'], data[key]['alamat_rt']]);
            }

            datatableModalDaftarRt.clear().draw();
            datatableModalDaftarRt.rows.add(rowsData).draw();

            $('#modal_daftar_rt').modal('show');            
          }
        })
      });


      $('.toggle_modal_tambah').on('click', function() {
        $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-plus"></i> Tambah Data');
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/dusun/store') ?>');
        $('#modal_tambah_dan_edit').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_edit', function() {
        const dusun_id = $(this).data('dusun_id');

        $.ajax({
          url: '<?= site_url('admin/dusun/get_dusun_by_id') ?>',
          type: 'POST',
          data: {
            dusun_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/dusun/update') ?>');

            $('#xdusun_id').val(data.id);
            $('#xnama').val(data.nama);
            $('#xalamat').val(data.alamat);

            $('#modal_tambah_dan_edit').modal('show');
          }
        })
      });


      $('.toggle_swal_hapus').on('click', function() {
        const dusun_id = $(this).data('dusun_id')

        Swal.fire({
          title: "Hapus Data?",
          text: "Tindakan tidak dapat diubah kembali!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, konfirmasi!"
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "Deleted!",
              text: "Tindakan dikonfirmasi!",
              icon: "success"
            });

            window.location = "<?= site_url('admin/dusun/destroy/') ?>" + dusun_id
          }
        });
      });


      $('#xdusun_id').on('change', function() {
        const dusun_id = $(this).val();

        return $.ajax({
          url: '<?= site_url("admin/dusun/get_all_rt/") ?>' + dusun_id,
          type: 'POST',
          data: {
            dusun_id: dusun_id
          },
          dataType: 'JSON',
          success: function(data) {
            // Clear option from current select
            const empty_option = '<option value="">-- Pilih -- </option>';
            $('#xrt_id').html(empty_option)

            // Add new option from retrieved data
            for (const key in data) {
              var new_option = new Option(data[key].rt, data[key].rt_id, false, false);
              $('#xrt_id').append(new_option);
            }
          }
        });
      });
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('admin/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>