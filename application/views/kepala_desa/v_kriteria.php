<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Kriteria - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('kepala_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('kepala_desa/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('kepala_desa/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Kriteria</a></li>
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

          <!--============================== INGFO ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-bullhorn"></i> Perhatian!</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown" style="visibility: hidden">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
          
                  <ol type="1" style="margin: 0; padding: 0 15px">
                    <li>Jika pada tahun x (misalnya 2024) <strong>sudah pernah menilai alternatif</strong>, maka kriteria mengikuti <strong>kriteria yang dinilai sebelumnya</strong>.</li>
                    <li>Lalu, pada tahun y (misalnya 2023) <strong>belum ada alternatif yang dinilai</strong>, maka kriteria mengikuti <strong>kriteria yang statusnya aktif</strong> saat ini.</li>
                  </ol>
          
                </div>
              </div>
            </div>
          </div>
          <!--//END INGFO -->

          <div class="clearfix"></div>
            
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Data Kriteria</h2>
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
                        <th>Nama</th>
                        <th>Atribut</th>
                        <th>Bobot</th>
                        <th>Status Aktif</th>
                        <th>Daftar Sub Kriteria</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($kriterias->result() as $kriteria) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $kriteria->kode ?></td>
                          <td><?= $kriteria->nama ?></td>
                          <td>
                            <?php
                            if ($kriteria->atribut === 'benefit') :
                              echo '<span class="badge alert-success">' . strtoupper($kriteria->atribut) . '</span>';
                            elseif ($kriteria->atribut === 'cost') :
                              echo '<span class="badge alert-danger">' . strtoupper($kriteria->atribut) . '</span>';
                            endif;
                            ?>
                          </td>
                          <td><?= $kriteria->bobot ?></td>
                          <td><input type="checkbox" class="js-switch toggle_status_aktif_kriteria" data-kriteria_id="<?= $kriteria->id ?>" <?= $kriteria->status_aktif ? 'checked' : '' ?>></td>
                          <td>
                            <button class="btn btn-dark btn-sm toggle_modal_daftar_sub_kriteria" data-kriteria_id="<?= $kriteria->id ?>">
                              <i class="fa fa-list"></i> Detail
                            </button>
                          </td>
                          <td>
                            <div class="form-button-action">
                              <!-- Toggle Modal Hapus -->
                              <span class="toggle_swal_hapus" data-kriteria_id="<?= $kriteria->id ?>">
                                <button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-times"></i></button>
                              </span>

                              <!-- Toggle Modal Edit -->
                              <span class="toggle_modal_edit" data-kriteria_id="<?= $kriteria->id ?>">
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
      $this->load->view('kepala_desa/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <!--============================== MODAL SUB KRITERIA ==============================-->
  <div class="modal fade" id="modal_daftar_sub_kriteria" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-list"></i> Daftar Sub Kriteria</h4>
        </div>
        <div class="modal-body">

          <h4 id="modal_daftar_sub_kriteria_title"></h4>

          <table class="table table-striped table-bordered jambo_table" id="modal_daftar_sub_kriteria_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Skor</th>
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
            <input type="hidden" name="xkriteria_id" id="xkriteria_id">

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xkode">Kode</label>
              <input type="text" name="xkode" id="xkode" class="form-control" placeholder="CXX" required>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="xatribut">Atribut</label>
              <select name="xatribut" id="xatribut" class="form-control select2">
                <option value="">-- Pilih --</option>
                <option value="benefit">Benefit</option>
                <option value="cost">Cost</option>
              </select>
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xnama">Nama Kriteria</label>
              <input required class="form-control" id="xnama" name="xnama" type="text">
            </div>

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="xbobot">Bobot</label>
              <input type="number" step="any" name="xbobot" id="xbobot" class="form-control" placeholder="xx.xxxxxx" required>
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

  <?php $this->load->view('kepala_desa/_partials/script') ?>

  <script>
    $(document).ready(function() {
      // Datatables initialise
      $('.datatables').DataTable({
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });

      var datatableModalDaftarSubKriteria = $('#modal_daftar_sub_kriteria_table').DataTable({
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


      $('.datatables').on('click', '.toggle_modal_daftar_sub_kriteria', function() {
        const kriteria_id = $(this).data('kriteria_id');

        $.ajax({
          url: '<?= site_url('kepala_desa/kriteria/get_all_sub_kriteria') ?>',
          type: 'POST',
          data: {
            kriteria_id
          },
          dataType: 'JSON',
          success: function(data) {
            console.log(data)
            $('#modal_daftar_sub_kriteria_title').html(data.kriteria);

            // add datatables row
            let i = 1;
            let rowsData = [];

            for (key in data) {
              rowsData.push([i++, data[key]['kode'], data[key]['nama'], data[key]['skor']]);
            }

            datatableModalDaftarSubKriteria.clear().draw();
            datatableModalDaftarSubKriteria.rows.add(rowsData).draw();

            $('#modal_daftar_sub_kriteria').modal('show');
          }
        })
      });


      $('.toggle_modal_tambah').on('click', function() {
        $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-plus"></i> Tambah Data');
        $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kepala_desa/kriteria/store') ?>');
        $('#modal_tambah_dan_edit').modal('show');
      });


      $('.datatables').on('click', '.toggle_modal_edit', function() {
        const kriteria_id = $(this).data('kriteria_id');

        $.ajax({
          url: '<?= site_url('kepala_desa/kriteria/get_kriteria_by_id') ?>',
          type: 'POST',
          data: {
            kriteria_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_tambah_dan_edit .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');
            $('#xform_modal_tambah_dan_edit').attr('action', '<?= site_url('kepala_desa/kriteria/update') ?>');

            $('#xkriteria_id').val(data.id);
            $('#xkode').val(data.kode);
            $('#xatribut').select().val(data.atribut).trigger('change');
            $('#xnama').val(data.nama);
            $('#xbobot').val(data.bobot);

            $('#modal_tambah_dan_edit').modal('show');
          }
        })
      });


      $('.datatables').on('click', '.toggle_swal_hapus', function() {
        const kriteria_id = $(this).data('kriteria_id')

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

            window.location = "<?= site_url('kepala_desa/kriteria/destroy/') ?>" + kriteria_id
          }
        });
      });


      $('.datatables').on('change', '.toggle_status_aktif_kriteria', function() {
        const kriteria_id = $(this).data('kriteria_id');
        console.log('uwaaaaaa')

        $.ajax({
          url: '<?= site_url('kepala_desa/kriteria/set_status_aktif') ?>',
          type: 'POST',
          data: {
            kriteria_id
          },
          dataType: 'JSON',
          success: function(data) {
            if (data) console.log('Berhasil update set status kriteria!');
            else console.log('Gagal update set status kriteria!');
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
  $this->load->view('kepala_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>