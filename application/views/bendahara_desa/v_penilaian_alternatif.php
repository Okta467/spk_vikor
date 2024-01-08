<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Penilaian Alternatif - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('bendahara_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('bendahara_desa/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('bendahara_desa/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Penilaian Alternatif</a></li>
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
                  <h2><i class="fa fa-user-md"></i> Data Penilaian Alternatif</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <div style="display: flex; flex-direction: row; align-items: center; justify-content: flex-end; width: 300px;">
                      <li style="width: 35%">Tahun Penilaian:</li>
                      <li style="width: 65%">
                        <form method="get" action="<?= site_url('bendahara_desa/penilaian_alternatif/') ?>">
                          <select name="tahun_penilaian" id="tahun_penilaian" class="form-control select2" onchange="this.form.submit()">
                            <option value="">-- Pilih Tahun Penilaian --</option>

                            <?php
                            foreach($tahun_penilaian_alternatifs as $tahun_penilaian_alternatif):
                              $tahun              = $tahun_penilaian_alternatif['tahun'];
                              $jumlah_data        = $tahun_penilaian_alternatif['jumlah_data'];
                              $is_selected_option = $tahun == $tahun_penilaian ? 'selected' : '';
                            ?>
          
                              <option value="<?= $tahun ?>" <?= $is_selected_option ?>><?= "{$tahun}" ?></option>
          
                            <?php endforeach ?>
                          </select>
                        </form>
                      </li>
                    </div>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Dusun</th>
                        <th>RT</th>
                        <th>KK Kepala Keluarga</th>
                        <th>NIK Kepala Keluarga</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th>Status Penilaian</th>
                        <th>Lihat Penilaian</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $penilaian_alternatif['dusun'] ?></td>
                          <td><?= $penilaian_alternatif['rt'] ?></td>
                          <td><?= $penilaian_alternatif['kk_kepala_keluarga'] ?></td>
                          <td><?= $penilaian_alternatif['nik_kepala_keluarga'] ?></td>
                          <td><?= $penilaian_alternatif['nama_kepala_keluarga'] ?></td>
                          <td><?= $penilaian_alternatif['alamat_alternatif'] ?></td>
                          <td>
                            <?php
                            if (!isset($penilaian_alternatif['penilaian_alternatif_id'])) :
                              echo '<span class="badge alert-danger">BELUM DINILAI</span>';
                            else :
                              echo '<span class="badge alert-success">SUDAH DINILAI</span>';
                            endif;
                            ?>
                          </td>
                          <td style="display: flex">
                            <div class="form-button-action" style="display: flex">

                              <!-- Toggle Modal Detail Penilaian -->
                              <?php if (!isset($penilaian_alternatif['penilaian_alternatif_id'])) : ?>
                                
                                <button class="btn btn-primary disabled" data-toggle="tooltip" data-placement="top" title="Belum Dinilai"><i class="fa fa-eye"></i></button>
                                
                              <?php else : ?>
                                
                                <span class="toggle_modal_detail_penilaian" 
                                  data-penilaian_alternatif_id="<?= $penilaian_alternatif['penilaian_alternatif_id'] ?>" 
                                  data-alternatif_id="<?= $penilaian_alternatif['alternatif_id'] ?>" 
                                  data-nama_kepala_keluarga="<?= $penilaian_alternatif['nama_kepala_keluarga'] ?>" 
                                  data-dusun="<?= $penilaian_alternatif['dusun'] ?>" 
                                  data-rt="<?= $penilaian_alternatif['rt'] ?>">
                                  <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Penilaian"><i class="fa fa-eye"></i></button>
                                </span>

                              <?php endif ?>
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
      $this->load->view('bendahara_desa/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <!--============================== MODAL DETAIL PENILAIAN ==============================-->
  <div class="modal fade" id="modal_detail_penilaian" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <h4><i class="fa fa-user-md"></i> Info Alternatif</h4>
              <p><b>Nama</b>: <span id="xnama_kepala_keluarga"></span></p>
              <p><b>Dusun</b>: <span id="xdusun"></span></p>
              <p><b>RT</b>: <span id="xrt"></span></p>
              <p class="text-danger" style="margin-top: 1.5em;">
                <i class="fa fa-bullhorn"></i> <strong>Perhatian!</strong>
                <br>Perubahan pada penilaian ini tidak akan mengubah apa pun (hanya tampilan saja)
              </p>
            </div>

            <?php foreach ($kriterias as $kriteria) : ?>

              <div class="form-group col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 1.5em">

                <input type="hidden" name="<?= "xkriteria_id_{$kriteria->kode}" ?>" value="<?= $kriteria->id ?>" class="xkriteria_id">

                <label><?= "{$kriteria->kode} - {$kriteria->nama}" ?></label>

                <?php
                foreach ($sub_kriterias as $sub_kriteria) :
                  if ($sub_kriteria->kriteria_id === $kriteria->id) :
                ?>

                  <div class="radio">
                    <label>
                      <input type="radio" name="<?= "xsub_kriteria_id_{$kriteria->kode}" ?>" value="<?= $sub_kriteria->id ?>" class="flat xsub_kriteria" required> <?= $sub_kriteria->nama ?>
                    </label>
                  </div>

                <?php
                  endif;
                endforeach
                ?>

              </div>

            <?php endforeach ?>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!--//END DETAIL PENILAIAN -->

  <?php $this->load->view('bendahara_desa/_partials/script') ?>

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

      // $('input[type="radio"]').iCheck('disable');


      $('.datatables').on('click', '.toggle_modal_detail_penilaian', function() {
        const data_btn = $(this).data();
        const tahun_penilaian = $('#tahun_penilaian').val();

        $.ajax({
          url: '<?= site_url('bendahara_desa/penilaian_alternatif/get_penilaian_alternatif') ?>',
          type: 'POST',
          data: {
            alternatif_id: data_btn.alternatif_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_detail_penilaian .modal-title').html('<i class="fa fa-pencil-square-o"></i> Edit Data');

            $('#xnama_kepala_keluarga').html(data_btn.nama_kepala_keluarga);
            $('#xdusun').html(data_btn.dusun);
            $('#xrt').html(data_btn.rt);
            
            // check radio button by value 
            for (key in data) {
              let kode_kriteria   = data[key]['kode_kriteria'];
              let sub_kriteria_id = data[key]['sub_kriteria_id'];
              let nama_input      = `xsub_kriteria_id_${kode_kriteria}`;

              $(`input[name="${nama_input}"][value="${sub_kriteria_id}"]`).iCheck('check')
            }

            $('#modal_detail_penilaian').modal('show');
          }
        })
      });
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('bendahara_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>