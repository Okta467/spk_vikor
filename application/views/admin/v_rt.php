<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data RT - {$this->config->config["webTitle"]}" ?></title>

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
                <li><a href="#">Data RT</a></li>
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
                  <h2><i class="fa fa-user-md"></i> Data RT</h2>
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
                        <th>Dusun</th>
                        <th>Alamat Dusun</th>
                        <th>RT</th>
                        <th>Alamat RT</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($rts->result() as $rt) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $rt->dusun ?></td>
                          <td><?= $rt->alamat_dusun ?></td>
                          <td><?= $rt->rt ?></td>
                          <td><?= $rt->alamat_rt ?></td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-rt_id="<?= $rt->rt_id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-rt_id="<?= $rt->rt_id ?>">
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
            <input type="hidden" name="xrt_id" id="xrt_id">

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xdusun_id">Dusun</label>
              <select name="xdusun_id" id="xdusun_id" class="form-control select2">
                <option value="">-- Pilih --</option>

                <?php foreach ($dusuns->result() as $dusun) : ?>

                  <option value="<?= $dusun->id ?>"><?= $dusun->nama ?></option>

                <?php endforeach; ?>

              </select>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xnama">RT</label>
              <input type="text" name="xnama" id="xnama" class="form-control" required>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xalamat">Alamat RT</label>
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

      $('.select2').select2({
        width: '100%'
      });


      $('.toggle_modal_tambah').on('click', function() {
        $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-plus"></i> Tambah Data');
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/rt/store') ?>');
        $('#modal_tambah_dan_edit').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_edit', function() {
        const rt_id = $(this).data('rt_id');

        $.ajax({
          url: '<?= site_url('admin/rt/get_rt_by_id') ?>',
          type: 'POST',
          data: {
            rt_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/rt/update') ?>');

            $('#xrt_id').val(data.id);
            $('#xdusun_id').val(data.dusun_id).select().trigger('change');
            $('#xnama').val(data.nama);
            $('#xalamat').val(data.alamat);

            $('#modal_tambah_dan_edit').modal('show');
          }
        })
      });


      $('.datatables').on('click', '.toggle_swal_hapus', function() {
        const rt_id = $(this).data('rt_id')

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

            window.location = "<?= site_url('admin/rt/destroy/') ?>" + rt_id
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