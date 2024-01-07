<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Hasil Perhitungan - {$this->config->config["webTitle"]}" ?></title>

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
                <li><a href="#">Data Hasil Perhitungan</a></li>
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

          <!--============================== PENILAIAN ALTERNATIF ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Penilaian Alternatif</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Alternatif</th>
                        <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                      </tr>
                      <tr>
                        <?php foreach($kriterias as $kriteria): ?>

                          <th class="text-center"><?= $kriteria->kode ?></th>

                        <?php endforeach ?>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                          <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>

                          <?php
                          foreach($kriterias as $kriteria): 
                            foreach($penilaian_alternatif_simples as $penilaian_alternatif_simple):

                              // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                              if (
                                $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                                && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                              ) :
                          ?>

                                <td><?= $penilaian_alternatif_simple->skor_sub_kriteria ?></td>

                          <?php
                                break;
                              endif;

                            endforeach;
                          endforeach;
                          ?>
                        </tr>

                      <?php endforeach ?>

                    </tbody>
                    <tfoot>
                      <!-- MIN/MAX -->
                      <tr>
                        <td colspan="3" class="text-right">Max = </td>
                        <?php foreach($kriterias as $kriteria): ?>

                          <td><?= $max_kriterias->{$kriteria->kode} ?></td>

                        <?php endforeach ?>
                      </tr>
                      <tr>
                        <td colspan="3" class="text-right">Min = </td>
                        <?php foreach($kriterias as $kriteria): ?>

                          <td><?= $min_kriterias->{$kriteria->kode} ?></td>
                          
                        <?php endforeach ?>
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>

          </div>
          <!--//END PENILAIAN ALTERNATIF -->

          <div class="clearfix"></div>

          <!--============================== NORMALISASI NILAI ALTERNATIF ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Normalisasi Nilai Alternatif (N<sub>ij</sub>)</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Alternatif</th>
                        <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                      </tr>
                      <tr>
                        <?php foreach($kriterias as $kriteria): ?>

                          <th class="text-center"><?= $kriteria->kode ?></th>

                        <?php endforeach ?>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                          <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>

                          <?php
                          foreach($kriterias as $kriteria): 
                            foreach($penilaian_alternatif_simples as $penilaian_alternatif_simple):

                              // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                              if (
                                $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                                && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                              ) :
                          ?>

                                <td>
                                  <?php
                                  $max_kriteria     = $max_kriterias->{$kriteria->kode};
                                  $min_kriteria     = $min_kriterias->{$kriteria->kode};
                                  $nilai_alternatif = $penilaian_alternatif_simple->skor_sub_kriteria;

                                  $hasil_normalisasi_nilai = ($max_kriteria - $min_kriteria) !== 0 
                                    ? ($max_kriteria - $nilai_alternatif) / ($max_kriteria - $min_kriteria) 
                                    : 0;

                                  echo $hasil_normalisasi_nilai;
                                  ?>
                                </td>

                          <?php
                                break;
                              endif;

                            endforeach;
                          endforeach;
                          ?>
                        </tr>

                      <?php endforeach ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>

          </div>
          <!--//END NORMALISASI NILAI ALTERNATIF -->

          <div class="clearfix"></div>

          <!--============================== TERBOBOT ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Terbobot</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Alternatif</th>
                        <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                      </tr>
                      <tr>
                        <?php foreach($kriterias as $kriteria): ?>

                          <th class="text-center"><?= $kriteria->kode ?></th>

                        <?php endforeach ?>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                          <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>

                          <?php
                          foreach($kriterias as $kriteria): 
                            foreach($penilaian_alternatif_simples as $penilaian_alternatif_simple):

                              // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                              if (
                                $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                                && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                              ) :
                          ?>

                                <td>
                                  <?php
                                  $max_kriteria     = $max_kriterias->{$kriteria->kode};
                                  $min_kriteria     = $min_kriterias->{$kriteria->kode};
                                  $nilai_alternatif = $penilaian_alternatif_simple->skor_sub_kriteria;
                                  $bobot_kriteria   = $penilaian_alternatif_simple->bobot_kriteria;

                                  $hasil_normalisasi_nilai = ($max_kriteria - $min_kriteria) !== 0 
                                      ? ($max_kriteria - $nilai_alternatif) / ($max_kriteria - $min_kriteria) 
                                      : 0;

                                  $terbobot = $hasil_normalisasi_nilai * $bobot_kriteria;

                                  echo $terbobot;
                                  ?>
                                </td>

                          <?php
                                break;
                              endif;

                            endforeach;
                          endforeach;
                          ?>
                        </tr>

                      <?php endforeach ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>

          </div>
          <!--//END TERBOBOT -->

          <div class="clearfix"></div>

          <!--============================== NILAI UTILITAS (S) DAN REGRET (R) ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Nilai Utilitas (S) dan Ukuran Regret (R)</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Alternatif</th>
                        <th rowspan="1" colspan="<?= $jumlah_kriteria + 2 ?>" class="text-center">Nama Kriteria</th>
                      </tr>
                      <tr>
                        <?php foreach($kriterias as $kriteria): ?>

                          <th class="text-center"><?= $kriteria->kode ?></th>

                        <?php endforeach ?>

                        <th class="text-center">S</th>
                        <th class="text-center">R</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                          <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>

                          <?php
                          foreach($kriterias as $kriteria): 
                            foreach($penilaian_alternatif_simples as $penilaian_alternatif_simple):

                              // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                              if (
                                $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                                && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                              ) :
                          ?>

                                <td>
                                  <?php
                                  $max_kriteria     = $max_kriterias->{$kriteria->kode};
                                  $min_kriteria     = $min_kriterias->{$kriteria->kode};
                                  $nilai_alternatif = $penilaian_alternatif_simple->skor_sub_kriteria;
                                  $bobot_kriteria   = $penilaian_alternatif_simple->bobot_kriteria;

                                  $hasil_normalisasi_nilai = ($max_kriteria - $min_kriteria) !== 0 
                                      ? ($max_kriteria - $nilai_alternatif) / ($max_kriteria - $min_kriteria) 
                                      : 0;

                                  $terbobot = $hasil_normalisasi_nilai * $bobot_kriteria;

                                  // masukkan entri terbobot ke array untuk perhitungan nilai S dan R
                                  !isset($terbobot_collection)
                                    ? $terbobot_collection = array($terbobot)
                                    : array_push($terbobot_collection, $terbobot);

                                  echo $terbobot;
                                  ?>
                                </td>

                          <?php
                                break;
                              endif;

                            endforeach;
                          endforeach;
                          ?>
                          
                          <!-- NILAI S DAN R -->
                          <td>
                            <?php
                            $nilai_s = array_sum($terbobot_collection);

                            // masukkan nilai_s ke penilaian alternatif untuk menentukan nilai vikor
                            $penilaian_alternatif->nilai_s = $nilai_s;

                            // masukkan semua nilai s ke array untuk menentukan min/max
                            !isset($nilai_s_collection)
                              ? $nilai_s_collection = array($nilai_s)
                              : array_push($nilai_s_collection, $nilai_s);
                            
                            echo $nilai_s;
                            ?>
                          </td>
                          <td>
                            <?php
                            $nilai_r = max($terbobot_collection);

                            // masukkan nilai_r ke penilaian alternatif untuk menentukan nilai vikor
                            $penilaian_alternatif->nilai_r = $nilai_r;

                            // masukkan semua nilai r ke array untuk menentukan min/max
                            !isset($nilai_r_collection)
                              ? $nilai_r_collection = array($nilai_r)
                              : array_push($nilai_r_collection, $nilai_r);
                            
                            echo $nilai_r;
                            ?>
                          </td>
                        </tr>

                      <?php endforeach ?>

                    </tbody>
                    <tfoot>
                      <!-- MIN/MAX S DAN R-->
                      <tr>
                        <td colspan="<?= $jumlah_kriteria + 3 ?>" class="text-right">&nbsp;</td>
                        <td>
                          S<sup>MAX</sup> = <?= max($nilai_s_collection) ?>
                        </td>
                        <td>
                          R<sup>MAX</sup> = <?= max($nilai_r_collection) ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="<?= $jumlah_kriteria + 3 ?>" class="text-right">&nbsp;</td>
                        <td>
                          S<sup>MIN</sup> = <?= min($nilai_s_collection) ?>
                        </td>
                        <td>
                          R<sup>MIN</sup> = <?= min($nilai_r_collection) ?>
                        </td>
                      </tr>
                    </tfoot>
                  </table>

                </div>
              </div>
            </div>

          </div>
          <!--//END NILAI UTILITAS (S) DAN REGRET (R) -->

          <div class="clearfix"></div>
          
          <!--============================== NILAI INDEKS VIKOR (RANKING) ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-pencil-square-o"></i> Indeks Vikor (Ranking)</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <!-- (HIDDEN) Set Nilai Vikor untuk Tampiilan Ranking -->
                  <?php
                  $min_s = min($nilai_s_collection);
                  $max_s = max($nilai_s_collection);

                  $min_r = min($nilai_r_collection);
                  $max_r = max($nilai_r_collection);

                  foreach ($penilaian_alternatifs as $penilaian_alternatif) {

                    // untuk menghindari exception division by zero
                    $penilaian_nilai_s = (($max_s - $min_s) !== 0)
                      ? ($penilaian_alternatif->nilai_s- $min_s) / ($max_s - $min_s)
                      : 0;
  
                    // untuk menghindari exception division by zero
                    $penilaian_nilai_r = (($max_r - $min_r) !== 0)
                      ? ($penilaian_alternatif->nilai_r - $min_r) / ($max_s - $min_s)
                      : 0;

                    $penilaian_alternatif->penilaian_nilai_s = $penilaian_nilai_s;
                    $penilaian_alternatif->penilaian_nilai_r = $penilaian_nilai_r;
                    
                    $penilaian_alternatif->nilai_vikor =
                        ($penilaian_nilai_s) * 0.5 + 
                        ($penilaian_nilai_r * (1 - 0.5));
                  }

                  // Urutkan penilaian berdasarkan nilai vikor (menaik) untuk perangkingan 
                  usort($penilaian_alternatifs, fn($a, $b) => $a->nilai_vikor <=> $b->nilai_vikor);
                  ?>
          
                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Alternatif</th>
                        <th>Perhitungan</th>
                        <th>Nilai Vikor</th>
                        <th>Ranking</th>
                      </tr>
                    </thead>
                    <tbody>
          
                      <?php
                      $no = 1;
                      foreach ($penilaian_alternatifs as $penilaian_alternatif) :
                      ?>
          
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                          <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>
                          <td>
                              <?= 
                                "(" . ($penilaian_alternatif->penilaian_nilai_s) . " * 0.5) + " .
                                "(" . ($penilaian_alternatif->penilaian_nilai_r) . " * 0.5)"
                              ?>
                          </td>
                          <td><?= $penilaian_alternatif->nilai_vikor ?></td>
                          <td><?= $no++ ?></td>
                        </tr>
          
                      <?php endforeach ?>
          
                    </tbody>
                  </table>
          
                </div>
              </div>
            </div>
          
          </div>
          <!--//END NILAI INDEKS VIKOR (RANKING) -->

          <div class="clearfix"></div>

          <!--============================== TOOLS ==============================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-gear"></i> Tools Hasil Perhitungan</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <div style="display: flex; flex-direction: row; align-items: center; justify-content: flex-end; width: 300px;">
                      <li style="width: 40%">
                        <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="Menampilkan ulang (reload) data hitung (halaman ini) berdasarkan tahun penilaian."></i>
                         Tahun Penilaian:
                      </li>
                      <li style="width: 60%">
                        <form method="get" action="<?= site_url('admin/hasil_perhitungan') ?>">
                          <select name="tahun_penilaian" id="tahun_penilaian" class="form-control select2" onchange="this.form.submit()">
                            <option value="">-- Pilih Tahun Penilaian --</option>
                            <option value="2024" selected>2024</option>

                            <?php for ($tahun = $tahun_penilaian - 1; $tahun >= 2000; $tahun--) : ?>

                              <option value="<?= $tahun ?>"><?= $tahun ?></option>

                            <?php endfor ?>
                          </select>
                        </form>
                      </li>
                    </div>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <a href="<?= site_url("admin/hasil_perhitungan/print/{$tahun_penilaian}") ?>" target="_blank" class="btn btn-primary" style="width: 100%;">
                    <i class="fa fa-print"></i> Cetak Data Perhitungan
                  </a>

                </div>
              </div>
            </div>

          </div>
          <!--//END TOOLS -->

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

  <?php $this->load->view('admin/_partials/script') ?>

  <script>
    $(document).ready(function() {
      // Datatables initialise
      $('.datatables').DataTable({
        fixedHeader: false,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });

      $('.select2').select2({
        width: '100%'
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