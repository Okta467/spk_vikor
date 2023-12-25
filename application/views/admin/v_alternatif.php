<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Alternatif - {$this->config->config["webTitle"]}" ?></title>

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
                <li><a href="#">Data Alternatif</a></li>
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
                  <h2>Data User Roles</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <button class="btn btn-primary toggle_modal_tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name Role</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($user_roles->result() as $user_role) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $user_role->nama_role ?></td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-id="<?= $user_role->id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-id="<?= $user_role->id ?>" data-nama_role="<?= $user_role->nama_role ?>">
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
      <footer>
        <div class="pull-right">
          Copyright &copy; <?= date("Y") ?> by <a href="#">SPK Vikor APP</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <!--============================== MODAL TAMBAH/EDIT ==============================-->
  <div class="modal fade" id="modal_tambah_dan_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
        </div>
        <div class="modal-body">

          <input type="hidden" name="xid" id="xid_user_role">
                  
          <div class="row">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="xnama_role">Nama Role <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" name="xname" id="xnama_role" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  <!--//END TAMBAH/EDIT -->

  <?php $this->load->view('admin/_partials/script') ?>

  <script>
    // Datatables initialise
    $('.datatables').DataTable({
      fixedHeader: true,
      pageLength: 5,
      lengthMenu: [
        [3, 5, 10, 25, 50, 100],
        [3, 5, 10, 25, 50, 100],
      ]
    });

    $('.toggle_modal_tambah').on('click', function() {
      $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-plus"></i> Tambah Data');

      $('#modal_tambah_dan_edit').modal('show');
    });

    $('.datatables').on('click', '.toggle_modal_edit', function() {
      const data = $(this).data();

      $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
      $('#xid_user_role').val(data.id);
      $('#xnama_role').val(data.nama_role);
      $('#modal_tambah_dan_edit').modal('show');
    });

    // Toggle swal hapus
    $('.toggle_swal_hapus').on('click', function() {
      const id_user_role = $(this).data('id')

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
            text: "Your file has been deleted.",
            icon: "success"
          });

          window.location = "<?= site_url('admin/user_role/hapus/') ?>" + id_user_role
        }
      });

    });
  </script>

</body>

</html>