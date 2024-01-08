<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Sub Kriteria - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('kasi_kesejahteraan_sosial/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('kasi_kesejahteraan_sosial/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('kasi_kesejahteraan_sosial/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Sub Kriteria</a></li>
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
                  <h2><i class="fa fa-pencil-square-o"></i> Data Sub Kriteria</h2>
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
                        <th>Kode Sub</th>
                        <th>Nama Sub</th>
                        <th>Skor Sub</th>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Atribut Kriteria</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($sub_kriterias->result() as $sub_kriteria) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $sub_kriteria->kode_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->nama_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->skor_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->kode_kriteria ?></td>
                          <td><?= $sub_kriteria->nama_kriteria ?></td>
                          <td>
                            <?php
                            if ($sub_kriteria->atribut_kriteria === 'benefit') :
                              echo '<span class="badge alert-success">' . strtoupper($sub_kriteria->atribut_kriteria) . '</span>';
                            elseif ($sub_kriteria->atribut_kriteria === 'cost') :
                              echo '<span class="badge alert-danger">' . strtoupper($sub_kriteria->atribut_kriteria) . '</span>';
                            endif;
                            ?>
                          </td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-sub_kriteria_id="<?= $sub_kriteria->sub_kriteria_id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-sub_kriteria_id="<?= $sub_kriteria->sub_kriteria_id ?>">
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
      $this->load->view('kasi_kesejahteraan_sosial/_partials/v_footer');
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
            <input type="hidden" name="xsub_kriteria_id" id="xsub_kriteria_id">

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xkriteria_id">Kriteria</label>
              <select name="xkriteria_id" id="xkriteria_id" class="form-control select2">
                <option value="">-- Pilih --</option>

                <?php foreach ($kriterias->result() as $kriteria) : ?>

                  <option value="<?= $kriteria->id ?>"><?= strtoupper($kriteria->atribut) . ' - ' . strtoupper($kriteria->kode) . ' - ' . $kriteria->nama ?></option>

                <?php endforeach; ?>

              </select>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xkode">Kode</label>
              <input type="text" name="xkode" id="xkode" class="form-control" placeholder="Contoh: C01SC01" required>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xnama">Nama</label>
              <input type="text" name="xnama" id="xnama" class="form-control" required>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xskor">Skor</label>
              <input type="number" name="xskor" min="0" max="10" id="xskor" class="form-control" placeholder="1 sampai 10" required>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="toggle_swal_submit">Simpan</button>
        </div>
        </form>
        <!--/.form -->
      </div>
    </div>
  </div>
  <!--//END TAMBAH/EDIT -->

  <?php $this->load->view('kasi_kesejahteraan_sosial/_partials/script') ?>

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
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kasi_kesejahteraan_sosial/sub_kriteria/store') ?>');
        $('#modal_tambah_dan_edit').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_edit', function() {
        const sub_kriteria_id = $(this).data('sub_kriteria_id');

        $.ajax({
          url: '<?= site_url('kasi_kesejahteraan_sosial/sub_kriteria/get_sub_kriteria_by_id') ?>',
          type: 'POST',
          data: {
            sub_kriteria_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kasi_kesejahteraan_sosial/sub_kriteria/update') ?>');

            $('#xsub_kriteria_id').val(data.id);
            $('#xkriteria_id').val(data.kriteria_id).select().trigger('change');
            $('#xkode').val(data.kode);
            $('#xnama').val(data.nama);
            $('#xskor').val(data.skor);

            $('#modal_tambah_dan_edit').modal('show');
          }
        })
      });


      $('.datatables').on('click', '.toggle_swal_hapus', function() {
        const sub_kriteria_id = $(this).data('sub_kriteria_id')

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

            window.location = "<?= site_url('kasi_kesejahteraan_sosial/sub_kriteria/destroy/') ?>" + sub_kriteria_id
          }
        });
      });


      // Simpan penilaian confirmation sweetalert
      $('#toggle_swal_submit').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('.modal-content').find('form');

        // Validate form before showing sweetalert
        if (!form[0].checkValidity()) {
          form[0].reportValidity();
        } else {
          Swal.fire({
            title: "Konfirmasi Tindakan??",
            text: "Harap perhatikan kembali input sebelum submit.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, konfirmasi!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Success!",
                text: "Tindakan dikonfirmasi!",
                icon: "success"
              });

              form.submit();
            }
          });
        }
      });
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('kasi_kesejahteraan_sosial/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>