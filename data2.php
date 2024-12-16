<?php
require('koneksi.php');

$sql1 = "SELECT s.nama_toko AS kategori, 
                t.bulan AS bulan,
                SUM(fp.amount) AS pendapatan
         FROM store s
         JOIN fakta_pendapatan fp ON s.store_id = fp.store_id
         JOIN time t ON fp.time_id = t.time_id
         GROUP BY kategori, bulan
         ORDER BY kategori, bulan";

$result1 = mysqli_query($conn, $sql1);

$pendapatan = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($pendapatan, array(
        "kategori" => $row['kategori'],
        "bulan" => $row['bulan'],
        "pendapatan" => $row['pendapatan']
    ));
}

$data2 = json_encode($pendapatan);
?>