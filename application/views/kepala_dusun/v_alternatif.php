<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Alternatif - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('kepala_dusun/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('kepala_dusun/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('kepala_dusun/_partials/v_header');
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
                  <h2><i class="fa fa-user-md"></i> Data Alternatif</h2>
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
                        <th>Kode</th>
                        <th>Dusun</th>
                        <th>RT</th>
                        <th>KK Kepala Keluarga</th>
                        <th>NIK Kepala Keluarga</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($alternatifs->result() as $alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $alternatif->kode_alternatif ?></td>
                          <td><?= $alternatif->dusun ?></td>
                          <td><?= $alternatif->rt ?></td>
                          <td><?= $alternatif->kk_kepala_keluarga ?></td>
                          <td><?= $alternatif->nik_kepala_keluarga ?></td>
                          <td><?= $alternatif->nama_kepala_keluarga ?></td>
                          <td><?= $alternatif->alamat_alternatif ?></td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-alternatif_id="<?= $alternatif->alternatif_id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-alternatif_id="<?= $alternatif->alternatif_id ?>">
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
      $this->load->view('kepala_dusun/_partials/v_footer');
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
            <input type="hidden" name="xalternatif_id" id="xalternatif_id">
            
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xkode">Kode Alternatif</label>
              <input type="text" name="xkode" id="xkode" class="form-control" placeholder="AXX" required>
            </div>

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
              <label for="xrt_id">RT</label>
              <select name="xrt_id" id="xrt_id" class="form-control select2">
                <option value="">-- Pilih --</option>
              </select>
              <small class="text-danger">*) Pilih dusun terlebih dahulu.</small>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xkk_kepala_keluarga">KK Kepala Keluarga</label>
              <input type="number" name="xkk_kepala_keluarga" id="xkk_kepala_keluarga" class="form-control" required>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xnik_kepala_keluarga">NIK Kepala Keluarga</label>
              <input type="number" name="xnik_kepala_keluarga" id="xnik_kepala_keluarga" class="form-control" required>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xnama_kepala_keluarga">Nama Kepala Keluarga</label>
              <input type="text" name="xnama_kepala_keluarga" id="xnama_kepala_keluarga" class="form-control" required>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xalamat_alternatif">Alamat</label>
              <textarea name="xalamat_alternatif" class="form-control" id="xalamat_alternatif" style="resize: vertical" rows="3"></textarea>
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

  <?php $this->load->view('kepala_dusun/_partials/script') ?>

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
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kepala_dusun/alternatif/store') ?>');
        $('#modal_tambah_dan_edit').modal('show');
      });

  
      $('.datatables').on('click', '.toggle_modal_edit', function() {
        const alternatif_id = $(this).data('alternatif_id');

        $.ajax({
          url: '<?= site_url('kepala_dusun/alternatif/get_alternatif_by_id') ?>',
          type: 'POST',
          data: {
            alternatif_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kepala_dusun/alternatif/update') ?>');
            
            $('#xalternatif_id').val(data.alternatif_id);
            $('#xkode').val(data.kode_alternatif);
            $('#xdusun_id').val(data.dusun_id).select().trigger('change');
            $('#xkk_kepala_keluarga').val(data.kk_kepala_keluarga);
            $('#xnik_kepala_keluarga').val(data.nik_kepala_keluarga);
            $('#xnama_kepala_keluarga').val(data.nama_kepala_keluarga);
            $('#xalamat_alternatif').val(data.alamat_alternatif);

            // I know this sometimes work, and not, but idk how to fix it
            $.ajax({
              url: '<?= site_url('kepala_dusun/alternatif/get_alternatif_by_id') ?>',
              type: 'POST',
              data: {
                alternatif_id
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
        const alternatif_id = $(this).data('alternatif_id')

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

            window.location = "<?= site_url('kepala_dusun/alternatif/destroy/') ?>" + alternatif_id
          }
        });
      });


      $('#xdusun_id').on('change', function() {
        const dusun_id = $(this).val();

        $.ajax({
          url: '<?= site_url("kepala_dusun/dusun/get_all_rt/") ?>' + dusun_id,
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
  $this->load->view('kepala_dusun/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>