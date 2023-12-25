<?php
$kriteria = array(
    'C1' => array(
        'name' => 'Harga',
        'bobot' => 0.45
    ),
    'C2' => array(
        'name' => 'Kamera',
        'bobot' => 0.25
    ),
    'C3' => array(
        'name' => 'Memori',
        'bobot' => 0.15
    ),
    'C4' => array(
        'name' => 'Berat',
        'bobot' => 0.1
    ),
    'C5' => array(
        'name' => 'Keunikan',
        'bobot' => 0.05
    ),
);

// Creating a 2-dimensional array with associative keys
$alternatif = array(
    'HP1' => array(
        'kode' => "A01",
        'name' => "HP1",
        'C1' => 80,
        'C2' => 70,
        'C3' => 80,
        'C4' => 70,
        'C5' => 90,
    ),
    'HP2' => array(
        'kode' => "A02",
        'name' => "HP2",
        'C1' => 80,
        'C2' => 80,
        'C3' => 70,
        'C4' => 70,
        'C5' => 90,
    ),
    'HP3' => array(
        'kode' => "A03",
        'name' => "HP3",
        'C1' => 90,
        'C2' => 70,
        'C3' => 80,
        'C4' => 70,
        'C5' => 80,
    )
);

// Max
$max_c1 = max(array_column($alternatif, 'C1'));
$max_c2 = max(array_column($alternatif, 'C2'));
$max_c3 = max(array_column($alternatif, 'C3'));
$max_c4 = max(array_column($alternatif, 'C4'));
$max_c5 = max(array_column($alternatif, 'C5'));

// Min
$min_c1 = min(array_column($alternatif, 'C1'));
$min_c2 = min(array_column($alternatif, 'C2'));
$min_c3 = min(array_column($alternatif, 'C3'));
$min_c4 = min(array_column($alternatif, 'C4'));
$min_c5 = min(array_column($alternatif, 'C5'));

function getNormalisasiNilaiAlternatif($nilai_alternatif, $max_kriteria, $min_kriteria) {
    return ($max_kriteria - $min_kriteria) !== 0 
        ? ($max_kriteria - $nilai_alternatif) / ($max_kriteria - $min_kriteria) 
        : 0;
}

function getTerbobot($kode_kriteria) {
    // return getNormalisasiNilaiAlternatif($row[$kode_kriteria], $max_c2, $min_c2) * $kriteria[$kode_kriteria]["bobot"];
}

?>

<!-- Penilaian Alternatif -->
<h3>Penilaian Alternatif</h3>
<table border="1" cellspacing="0" width="30%">
    <thead>
        <tr>
            <th rowspan="2">Kode</th>
            <th rowspan="2">Alternatif</th>
            <th colspan="5">Nama Kriteria</td>
        </tr>
        <tr>
            <th>C01</th>
            <th>C02</th>
            <th>C03</th>
            <th>C04</th>
            <th>C05</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($alternatif as $row): ?>

            <tr>
                <td><?= $row["kode"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= $row["C1"] ?></td>
                <td><?= $row["C2"] ?></td>
                <td><?= $row["C3"] ?></td>
                <td><?= $row["C4"] ?></td>
                <td><?= $row["C5"] ?></td>
            </tr>

        <?php endforeach; ?>

        <tr>
            <td colspan="2">Max</td>
            <td><?= $max_c1 ?></td>
            <td><?= $max_c2 ?></td>
            <td><?= $max_c3 ?></td>
            <td><?= $max_c4 ?></td>
            <td><?= $max_c5 ?></td>
        </tr>
        <tr>
            <td colspan="2">Min</td>
            <td><?= $min_c1 ?></td>
            <td><?= $min_c2 ?></td>
            <td><?= $min_c3 ?></td>
            <td><?= $min_c4 ?></td>
            <td><?= $min_c5 ?></td>
        </tr>

    </tbody>
</table>

<!-- Normalisasi Nilai Alternatif (Nij) -->
<h3>Normalisasi Nilai Alternatif (N<sub>ij</sub>)</h3>
<table border="1" cellspacing="0" width="30%">
    <thead>
        <tr>
            <th rowspan="2">Kode</th>
            <th rowspan="2">Alternatif</th>
            <th colspan="7">Nama Kriteria</th>
        </tr>
        <tr>
            <th>C01</th>
            <th>C02</th>
            <th>C03</th>
            <th>C04</th>
            <th>C05</th>
    </thead>
    <tbody>

        <?php foreach ($alternatif as $row): ?>

            <tr>
                <td><?= $row["kode"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C1"], $max_c1, $min_c1) ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C2"], $max_c2, $min_c2) ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C3"], $max_c3, $min_c3) ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C4"], $max_c4, $min_c4) ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C5"], $max_c5, $min_c5) ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<!-- Terbobot -->
<h3>Terbobot</h3>
<table border="1" cellspacing="0" width="30%">
    <thead>
        <tr>
            <th rowspan="2">Kode</th>
            <th rowspan="2">Alternatif</th>
            <th colspan="5">Nama Kriteria</td>
        </tr>
        <tr>
            <th>C01</th>
            <th>C02</th>
            <th>C03</th>
            <th>C04</th>
            <th>C05</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($alternatif as $row): ?>

            <tr>
                <td><?= $row["kode"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C1"], $max_c1, $min_c1) * $kriteria["C1"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C2"], $max_c2, $min_c2) * $kriteria["C2"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C3"], $max_c3, $min_c3) * $kriteria["C3"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C4"], $max_c4, $min_c4) * $kriteria["C4"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($row["C5"], $max_c5, $min_c5) * $kriteria["C5"]["bobot"] ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

<!-- Nilai Utilitas (S) dan Ukuran Regret (R) -->
<h3>Nilai Utilitas (S) dan Ukuran Regret (R)</h3>
<table border="1" cellspacing="0" width="30%">
    <thead>
        <tr>
            <th rowspan="2">Kode</th>
            <th rowspan="2">Alternatif</th>
            <th colspan="7">Nama Kriteria</th>
        </tr>
        <tr>
            <th>C01</th>
            <th>C02</th>
            <th>C03</th>
            <th>C04</th>
            <th>C05</th>
            <td>S</td>
            <td>R</td>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($alternatif as $key => $value): ?>

            <tr>
                <td><?= $alternatif[$key]["kode"] ?></td>
                <td><?= $alternatif[$key]["name"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($alternatif[$key]["C1"], $max_c1, $min_c1) * $kriteria["C1"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($alternatif[$key]["C2"], $max_c2, $min_c2) * $kriteria["C2"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($alternatif[$key]["C3"], $max_c3, $min_c3) * $kriteria["C3"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($alternatif[$key]["C4"], $max_c4, $min_c4) * $kriteria["C4"]["bobot"] ?></td>
                <td><?= getNormalisasiNilaiAlternatif($alternatif[$key]["C5"], $max_c5, $min_c5) * $kriteria["C5"]["bobot"] ?></td>
                <td>
                    <?php
                        $alternatif[$key]["nilai_s"] =
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C1"], $max_c1, $min_c1) * $kriteria["C1"]["bobot"]) +
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C2"], $max_c2, $min_c2) * $kriteria["C2"]["bobot"]) +
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C3"], $max_c3, $min_c3) * $kriteria["C3"]["bobot"]) +
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C4"], $max_c4, $min_c4) * $kriteria["C4"]["bobot"]) +
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C5"], $max_c5, $min_c5) * $kriteria["C5"]["bobot"]);
                        
                        echo $alternatif[$key]["nilai_s"];

                        // Set new min_s by current nilai_s if not exist, else compare last value to current one
                        !isset($min_s)
                            ? $min_s = $alternatif[$key]["nilai_s"]
                            : $min_s = $alternatif[$key]["nilai_s"] < $min_s ? $alternatif[$key]["nilai_s"] : $min_s;
                        
                        // Set new max_s by current nilai_s if not exist, else compare last value to current one
                        !isset($max_s)
                            ? $max_s = $alternatif[$key]["nilai_s"]
                            : $max_s = $alternatif[$key]["nilai_s"] > $max_s ? $alternatif[$key]["nilai_s"] : $max_s;
                    ?>
                </td>
                <td>
                    <?php
                        $alternatif[$key]["nilai_r"] = max([
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C1"], $max_c1, $min_c1) * $kriteria["C1"]["bobot"]),
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C2"], $max_c2, $min_c2) * $kriteria["C2"]["bobot"]),
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C3"], $max_c3, $min_c3) * $kriteria["C3"]["bobot"]),
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C4"], $max_c4, $min_c4) * $kriteria["C4"]["bobot"]),
                            (getNormalisasiNilaiAlternatif($alternatif[$key]["C5"], $max_c5, $min_c5) * $kriteria["C5"]["bobot"])
                        ]);
                        
                        echo $alternatif[$key]["nilai_r"];

                        // Set new min_r by current nilai_r if not exist, else compare last value to current one
                        !isset($min_r)
                            ? $min_r = $alternatif[$key]["nilai_r"]
                            : $min_r = $alternatif[$key]["nilai_r"] < $min_r ? $alternatif[$key]["nilai_r"] : $min_r;
                        
                        // Set new max_r by current nilai_r if not exist, else compare last value to current one
                        !isset($max_r)
                            ? $max_r = $alternatif[$key]["nilai_r"]
                            : $max_r = $alternatif[$key]["nilai_r"] > $max_r ? $alternatif[$key]["nilai_r"] : $max_r;

                    ?>
                </td>
            </tr>

        <?php endforeach; ?>

        <tr>
            <td colspan="7">&nbsp;</td>
            <td>S<sup>max</sup> = <?= $max_s ?></td>
            <td>R<sup>max</sup> = <?= $max_r ?></td>
        </tr>
        <tr>
            <td colspan="7">&nbsp;</td>
            <td>S<sup>min</sup> = <?= $min_s ?></td>
            <td>R<sup>min</sup> = <?= $min_r ?></td>
        </tr>

    </tbody>
</table>

<!-- (HIDDEN) Set Nilai Vikor untuk Tampiilan Ranking -->
<?php
    foreach ($alternatif as $key => $value){
        $alternatif[$key]["nilai_vikor"] =
            (($alternatif[$key]["nilai_s"]- $min_s) / ($max_s - $min_s)) * 0.5 + 
            (($alternatif[$key]['nilai_r'] - $min_r) / ($max_r - $min_r) * (1 - 0.5));
    }

    // Urutkan penilaian berdasarkan nilai vikor (menaik) untuk perangkingan 
    uasort($alternatif, fn($a, $b) => $a['nilai_vikor'] <=> $b['nilai_vikor']);
?>

<!-- Indeks Vikor (Ranking) -->
<h3>Indeks Vikor (Ranking)</h3>
<table border="1" cellspacing="0" width="30%">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Alternatif</th>
            <th>Perhitungan</th>
            <th>Nilai Vikor</th>
            <th>Ranking</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $i = 1;
        foreach ($alternatif as $key => $value): 
        ?>

            <tr>
                <td><?= $alternatif[$key]["kode"] ?></td>
                <td><?= $alternatif[$key]["name"] ?></td>
                <td>
                    <?= 
                        "(" . (($alternatif[$key]["nilai_s"] - $min_s) / ($max_s - $min_s)) . " * 0.5) + " .
                        "(" . (($alternatif[$key]['nilai_r'] - $min_r) / ($max_r - $min_r)) . " * 0.5)"
                    ?>
                </td>
                <td>
                    <?php
                        $alternatif["nilai_vikor"] =
                            (($alternatif[$key]["nilai_s"]- $min_s) / ($max_s - $min_s)) * 0.5 + 
                            (($alternatif[$key]['nilai_r'] - $min_r) / ($max_r - $min_r) * (1 - 0.5));

                        echo $alternatif["nilai_vikor"];
                    ?>
                </td>
                <td><?= $i++ ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>