<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data User - {$this->config->config["webTitle"]}" ?></title>

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
                  <h2><i class="fa fa-users"></i> Data Users</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <button class="btn btn-primary btn-sm toggle_modal_tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <p class="text-muted font-13 m-b-30">Hanya hak akses <b>Kepala Dusun</b> dan <b>Ketua RT</b> yang memiliki dusun dan RT.</p>

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Dusun</th>
                        <th>RT</th>
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
                          <td><?= $user->dusun ?? '-' ?></td>
                          <td><?= $user->rt ?? '-' ?></td>
                          <td><?= $user->nama_pemilik ?></td>
                          <td><?= $user->username ?></td>
                          <td>
                            <?php
                            if ($user->hak_akses === 'admin') :
                              echo '<span class="badge alert-danger">' . $user->hak_akses . '</span>';
                            elseif (in_array($user->hak_akses, ['kepala_desa', 'sekretaris_desa', 'bendahara_desa', 'kasi_kesejahteraan_sosial'])) :
                              echo '<span class="badge">' . $user->hak_akses . '</span>';
                            elseif (in_array($user->hak_akses, ['kepala_dusun', 'ketua_rt'], $user->hak_akses)) :
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
            <input type="hidden" name="xuser_id" id="xuser_id">

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xdusun_id">Dusun</label>
              <select name="xdusun_id" id="xdusun_id" class="form-control select2">
                <option value="">-- Pilih --</option>

                <?php foreach ($dusuns->result() as $dusun) : ?>

                  <option value="<?= $dusun->id ?>"><?= $dusun->nama ?></option>

                <?php endforeach; ?>

              </select>
              <small class="text-danger">*) Kosongkan jika bukan <b>Kepala Desa</b> dan <b>Ketua RT</b>.</small>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xrt_id">RT</label>
              <select name="xrt_id" id="xrt_id" class="form-control select2">
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
              <small>*) Hanya boleh huruf dan angka.</small>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xpassword">Password</label>
              <input type="password" name="xpassword" id="xpassword" class="form-control" autocomplete="new-password" required aria-autocomplete="list">
              <small id="xpassword_help" class="hide">*) Kosongkan jika tidak ingin diubah.</small>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xhak_akses">Hak Akses</label>
              <select name="xhak_akses" id="xhak_akses" class="form-control select2" required>
                <option value="">-- Pilih --</option>
                <option value="admin">Admin</option>
                <option value="kepala_desa">Kepala Desa</option>
                <option value="sekretaris_desa">Sekretaris Desa</option>
                <option value="bendahara_desa">Bendahara Desa</option>
                <option value="kasi_kesejahteraan_sosial">Kasi Kesejahteraan Sosial</option>
                <option value="kepala_dusun">kepala_dusun</option>
                <option value="ketua_rt">ketua_rt</option>
              </select>
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
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/user/store') ?>');
        $('#xpassword').attr('required', true);
        $('#xpassword_help').addClass('hide');
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
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('admin/user/update') ?>');
            
            $('#xuser_id').val(data.user_id);
            $('#xdusun_id').val(data.dusun_id).select().trigger('change');
            $('#xrt_id').val(data.rt_id).trigger('change'); // idk why this doesn't work (chatGPT said ajax timing)
            $('#xnama_pemilik').val(data.nama_pemilik);
            $('#xusername').val(data.username);
            $('#xhak_akses').val(data.hak_akses).select().trigger('change');
            $('#xpassword').attr('required', false);
            $('#xpassword_help').removeClass('hide');

            // I know this sometimes work, and not, but idk how to fix it
            $.ajax({
              url: '<?= site_url('admin/user/get_user_by_id') ?>',
              type: 'POST',
              data: {
                user_id
              },
              dataType: 'JSON',
              success: function(data) {
                $('#xrt_id').val(data.rt_id).select().trigger('change');
              }
            });

            $('#modal_tambah_dan_edit').modal('show');
          }
        })
      });


      $('.datatables').on('click', '.toggle_swal_hapus', function() {
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
              text: "Tindakan dikonfirmasi!",
              icon: "success"
            });

            window.location = "<?= site_url('admin/user/destroy/') ?>" + user_id
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


      $('#xhak_akses').on('change', function() {
        const hak_akses = $(this).val();

        if (["kepala_dusun", "ketua_rt"].includes(hak_akses)) {
          $('#xdusun_id, #xrt_id').attr('required', true);
        } else {
          $('#xdusun_id, #xrt_id').attr('required', false);
        }
      })
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('admin/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>