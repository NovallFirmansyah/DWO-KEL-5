<?php
require('koneksi.php');

// Query untuk mengambil data kategori produk terlaris per bulan
$sql1 = "SELECT dp.productname AS barang, 
                COUNT(fp.productID) AS jumlah
         FROM factsales fp
         JOIN dimproduct dp ON fp.productID = dp.productID
         GROUP BY dp.productname
         ORDER BY jumlah DESC";

// Eksekusi query
$result1 = mysqli_query($conn, $sql1);

// Array untuk menampung data
$barangTerlaris = array();

// Mengambil data dari hasil query
while ($row = mysqli_fetch_array($result1)) {
    array_push($barangTerlaris, array(
        "barang" => $row['barang'],
        "jumlah" => $row['jumlah']
    ));
}

// Mengencode hasil ke format JSON
$data3 = json_encode($barangTerlaris);
?>