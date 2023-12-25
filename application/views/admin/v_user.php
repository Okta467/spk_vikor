<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Dashboard - {$this->config->config["webTitle"]}" ?></title>

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
                <li><a href="#">Data Users</a></li>
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
                  <h2>Data Users</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <button class="btn btn-primary btn-sm toggle_modal_tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama Pemilik</th>
                        <th>Username</th>
                        <th>Hak Akses</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($users->result() as $user) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $user->nama_pemilik ?></td>
                          <td><?= $user->username ?></td>
                          <td>
                            <?php
                            if ($user->hak_akses === 'admin') :
                              echo '<span class="badge alert-danger">' . $user->hak_akses . '</span>';
                            elseif (in_array(['kepala_desa', 'sekretaris_desa', 'bendahara_desa', 'kasi_kesejahteraan_sosial'], $user->hak_akses)) :
                              echo '<span class="badge">' . $user->hak_akses . '</span>';
                            elseif (in_array(['kepala_dusun', 'ketua_rt'], $user->hak_akses)) :
                              echo '<span class="badge alert-info">' . $user->hak_akses . '</span>';
                            else :
                              echo $user->hak_akses;
                            endif;
                            ?>
                          </td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-user_id="<?= $user->user_id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-user_id="<?= $user->user_id ?>">
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left" id="xform_modal_tambah_dan_edit">

            <!-- For updating data -->
            <input type="hidden" name="xuser_id" id="xuser_id">

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xdusun_id">Dusun</label>
              <select name="xdusun_id" id="xdusun_id" class="form-control">
                <option value="">-- Pilih --</option>
              </select>
              <small class="text-danger">*) Kosongkan jika bukan <b>Kepala Desa</b> dan <b>Ketua RT</b>.</small>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xrt_id">RT</label>
              <select name="xrt_id" id="xrt_id" class="form-control">
                <option value="">-- Pilih --</option>
              </select>
              <small class="text-danger">*) Pilih dusun terlebih dahulu.</small>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xnama_pemilik">Nama Pemilik</label>
              <input type="text" name="xnama_pemilik" id="xnama_pemilik" class="form-control" required>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xusername">Username</label>
              <input type="text" name="xusername" id="xusername" class="form-control" required>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xpassword">Password</label>
              <input type="password" name="xpassword" id="xpassword" class="form-control" autocomplete="new-password" required aria-autocomplete="list">
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xhak_akses">Hak Akses</label>
              <select name="xhak_akses" id="xhak_akses" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="admin">Admin</option>
                <option value="kepala_desa">Kepala Desa</option>
                <option value="sekretaris_desa">Sekretaris Desa</option>
                <option value="bendahara_desa">Bendahara Desa</option>
                <option value="kasi_kesejahteraan_sosial">Kasi Kesejahteraan Sosial</option>
              </select>
            </div>
            
          </form>
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
      const user_id = $(this).data('user_id');

      $.ajax({
        url: '<?= site_url('admin/user/get_user_by_id') ?>',
        type: 'POST',
        data: {
          user_id
        },
        dataType: 'JSON',
        success: function(data) {
          $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
          
          $('#xuser_id').val(data.user_id);
          $('#xdusun_id').val(data.dusun_id).prop('change');
          $('#xrt_id').val(data.rt_id).prop('change');
          $('#xnama_pemilik').val(data.nama_pemilik);
          $('#xusername').val(data.username);
          $('#xhak_akses').val(data.username).prop('change');

          $('#modal_tambah_dan_edit').modal('show');
        }
      })
    });

    // Toggle swal hapus
    $('.toggle_swal_hapus').on('click', function() {
      const user_id = $(this).data('user_id')

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

          window.location = "<?= site_url('admin/user/destroy/') ?>" + user_id
        }
      });

    });
  </script>

</body>

</html>