<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Hasil Perhitungan - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('sekretaris_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <div class="">
    
    <!--============================== KOP ==============================-->
    <div class="x_panel" style="display: flex; flex-direction: row; align-items: center; justify-content: center; border: none; border-bottom: 5px groove black; margin-bottom: 1.5em">
      <img src="<?= base_url('assets/images/icon.png') ?>" style="height: 130px;margin-right: 1.5em;">
      <div>
        <h2 style="font-weight: bold;line-height: 1.5;text-align: center;">
          <span style="font-size: 1.25em;">
            PEMERINTAH KABAUPATEN BANYUASIN <br>
            KECAMATAN SEMBAWA <br>
          </span>
          <span style="font-size: 1.5em;">
            DESA PULAU HARAPAN
          </span>
        </h2>
        <p>Alamat: Dusun 2, RT-001, No-104, Desa Pulau Harapan, Betung, Palembang (30753)</p>
      </div>
    </div>
    <!--//END KOP -->
    
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
    
            <table class="table table-striped table-bordered jambo_table">
              <thead>
                <tr>
                  <th rowspan="2">#</th>
                  <th rowspan="2">Kode</th>
                  <th rowspan="2">Alternatif</th>
                  <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                </tr>
                <tr>
                  <?php
                  if ($jumlah_kriteria > 1) :
                    foreach ($kriterias as $kriteria) : ?>
    
                      <th class="text-center"><?= $kriteria->kode ?></th>
    
                    <?php
                    endforeach;
                  else :
                    ?>
    
                    <th class="text-center">Tidak Ada</th>
    
                  <?php endif ?>
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
    
            <table class="table table-striped table-bordered jambo_table">
              <thead>
                <tr>
                  <th rowspan="2">#</th>
                  <th rowspan="2">Kode</th>
                  <th rowspan="2">Alternatif</th>
                  <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                </tr>
                <tr>
                  <?php
                  if ($jumlah_kriteria > 1) :
                    foreach ($kriterias as $kriteria) : ?>
    
                      <th class="text-center"><?= $kriteria->kode ?></th>
    
                    <?php
                    endforeach;
                  else :
                    ?>
    
                    <th class="text-center">Tidak Ada</th>
    
                  <?php endif ?>
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
                            $max_skor_kriteria = $max_skor_kriterias->{$kriteria->kode};
                            $min_skor_kriteria = $min_skor_kriterias->{$kriteria->kode};
                            $nilai_alternatif  = $penilaian_alternatif_simple->skor_sub_kriteria;
    
                            if ($kriteria->atribut === 'benefit'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($max_skor_kriteria - $nilai_alternatif) / ($max_skor_kriteria - $min_skor_kriteria) 
                                : 0;
                                
                            elseif ($kriteria->atribut === 'cost'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($min_skor_kriteria - $nilai_alternatif) / ($min_skor_kriteria - $max_skor_kriteria)
                                : 0;
    
                            endif;
    
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
    
            <table class="table table-striped table-bordered jambo_table">
              <thead>
                <tr>
                  <th rowspan="2">#</th>
                  <th rowspan="2">Kode</th>
                  <th rowspan="2">Alternatif</th>
                  <th rowspan="1" colspan="<?= $jumlah_kriteria ?>" class="text-center">Nama Kriteria</th>
                </tr>                      <tr>
                  <?php
                  if ($jumlah_kriteria > 1) :
                    foreach ($kriterias as $kriteria) : ?>
    
                      <th class="text-center"><?= $kriteria->kode ?></th>
    
                    <?php
                    endforeach;
                  else :
                    ?>
    
                    <th class="text-center">Tidak Ada</th>
    
                  <?php endif ?>
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
                    foreach ($kriterias as $kriteria) :
                      foreach ($penilaian_alternatif_simples as $penilaian_alternatif_simple) :
    
                        // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                        if (
                          $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                          && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                        ) :
                    ?>
    
                          <td>
                            <?php
                            $max_skor_kriteria = $max_skor_kriterias->{$kriteria->kode};
                            $min_skor_kriteria = $min_skor_kriterias->{$kriteria->kode};
                            $nilai_alternatif  = $penilaian_alternatif_simple->skor_sub_kriteria;
                            $bobot_kriteria    = $penilaian_alternatif_simple->bobot_kriteria;
    
                            if ($kriteria->atribut === 'benefit'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($max_skor_kriteria - $nilai_alternatif) / ($max_skor_kriteria - $min_skor_kriteria) 
                                : 0;
                                
                            elseif ($kriteria->atribut === 'cost'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($min_skor_kriteria - $nilai_alternatif) / ($min_skor_kriteria - $max_skor_kriteria)
                                : 0;
    
                            endif;
    
                            $terbobot = $hasil_normalisasi_nilai * $bobot_kriteria;
    
                            echo number_format($terbobot, 4, '.', ',');
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
    
            <table class="table table-striped table-bordered jambo_table">
              <thead>
                <tr>
                  <th rowspan="2">#</th>
                  <th rowspan="2">Kode</th>
                  <th rowspan="2">Alternatif</th>
                  <th rowspan="1" colspan="<?= $jumlah_kriteria + 2 ?>" class="text-center">Nama Kriteria</th>
                </tr>
                <tr>
                  <?php foreach ($kriterias as $kriteria) : ?>
    
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
                    <td><?= $no ?></td>
                    <td><?= $penilaian_alternatif->kode_alternatif ?></td>
                    <td><?= $penilaian_alternatif->nama_kepala_keluarga ?></td>
    
                    <?php
                    foreach ($kriterias as $kriteria) :
                      foreach ($penilaian_alternatif_simples as $penilaian_alternatif_simple) :
    
                        // Tampilkan berdasarkan alternatif_id dan kode_kriteria untuk kolom ini
                        if (
                          $penilaian_alternatif_simple->alternatif_id === $penilaian_alternatif->alternatif_id
                          && $penilaian_alternatif_simple->kode_kriteria === $kriteria->kode
                        ) :
                    ?>
    
                          <td>
                            <?php
                            $max_skor_kriteria = $max_skor_kriterias->{$kriteria->kode};
                            $min_skor_kriteria = $min_skor_kriterias->{$kriteria->kode};
                            $nilai_alternatif  = $penilaian_alternatif_simple->skor_sub_kriteria;
                            $bobot_kriteria    = $penilaian_alternatif_simple->bobot_kriteria;
    
                            if ($kriteria->atribut === 'benefit'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($max_skor_kriteria - $nilai_alternatif) / ($max_skor_kriteria - $min_skor_kriteria) 
                                : 0;
                                
                            elseif ($kriteria->atribut === 'cost'):
    
                              $hasil_normalisasi_nilai = ($max_skor_kriteria - $min_skor_kriteria) !== 0 
                                ? ($min_skor_kriteria - $nilai_alternatif) / ($min_skor_kriteria - $max_skor_kriteria)
                                : 0;
    
                            endif;
    
                            $terbobot = $hasil_normalisasi_nilai * $bobot_kriteria;
    
                            // masukkan entri terbobot ke array untuk perhitungan nilai S dan R
                            !isset($terbobot_collection[$no])
                              ? $terbobot_collection[$no] = array($terbobot)
                              : array_push($terbobot_collection[$no], $terbobot);
    
                            echo number_format($terbobot, 4, '.', ',');
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
                      $nilai_s = array_sum($terbobot_collection[$no]);
    
                      // masukkan nilai_s ke penilaian alternatif untuk menentukan nilai vikor
                      $penilaian_alternatif->nilai_s = $nilai_s;
    
                      // masukkan semua nilai s ke array untuk menentukan min/max
                      !isset($nilai_s_collection)
                        ? $nilai_s_collection = array($nilai_s)
                        : array_push($nilai_s_collection, $nilai_s);
    
                      echo number_format($nilai_s, 4, '.', ',');
                      ?>
                    </td>
                    <td>
                      <?php
                      $nilai_r = max($terbobot_collection[$no]);
    
                      // masukkan nilai_r ke penilaian alternatif untuk menentukan nilai vikor
                      $penilaian_alternatif->nilai_r = $nilai_r;
    
                      // masukkan semua nilai r ke array untuk menentukan min/max
                      !isset($nilai_r_collection)
                        ? $nilai_r_collection = array($nilai_r)
                        : array_push($nilai_r_collection, $nilai_r);
    
                      echo number_format($nilai_r, 4, '.', ',');
                      ?>
                    </td>
                  </tr>
    
                <?php $no++ ?>
                <?php endforeach ?>
    
              </tbody>
    
              <?php if($penilaian_alternatifs): ?>
    
                <tfoot>
                  <!-- MIN/MAX S DAN R-->
                  <tr>
                    <td colspan="<?= $jumlah_kriteria + 3 ?>" class="text-right">&nbsp;</td>
                    <td>
                      S<sup>MAX</sup> = <?= number_format(max($nilai_s_collection), 4, '.', ',') ?>
                    </td>
                    <td>
                      R<sup>MAX</sup> = <?= number_format(max($nilai_r_collection), 4, '.', ',') ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="<?= $jumlah_kriteria + 3 ?>" class="text-right">&nbsp;</td>
                    <td>
                      S<sup>MIN</sup> = <?= number_format(min($nilai_s_collection), 4, '.', ',') ?>
                    </td>
                    <td>
                      R<sup>MIN</sup> = <?= number_format(min($nilai_r_collection), 4, '.', ',') ?>
                    </td>
                  </tr>
                </tfoot>
                
              <?php endif ?>
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
            if ($penilaian_alternatifs) {
              $min_s = min($nilai_s_collection);
              $max_s = max($nilai_s_collection);
      
              $min_r = min($nilai_r_collection);
              $max_r = max($nilai_r_collection);
      
              foreach ($penilaian_alternatifs as $penilaian_alternatif) {
      
                // untuk menghindari exception division by zero
                $penilaian_nilai_s = (($max_s - $min_s) !== 0)
                  ? ($penilaian_alternatif->nilai_s - $min_s) / ($max_s - $min_s)
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
              usort($penilaian_alternatifs, fn ($a, $b) => $a->nilai_vikor <=> $b->nilai_vikor);
            }
            ?>
    
            <table class="table table-striped table-bordered jambo_table">
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
                      "(" . (number_format($penilaian_alternatif->penilaian_nilai_s, 4, '.', ',')) . " * 0.5) + " .
                        "(" . (number_format($penilaian_alternatif->penilaian_nilai_r, 4, '.', ',')) . " * 0.5)"
                      ?>
                    </td>
                    <td><?= number_format($penilaian_alternatif->nilai_vikor, 4, '.', ',') ?></td>
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

  </div>
  <!--//END CONTAINER -->

  <?php $this->load->view('sekretaris_desa/_partials/script') ?>

  <script>
    $(document).ready(function() {
      // Datatables initialise
      $('.datatables').DataTable({
        fixedHeader: false,
        pageLength: -1,  // Set to -1 to show all rows by default
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });

      $('.select2').select2({
        width: '100%'
      });

      window.print();
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('sekretaris_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>