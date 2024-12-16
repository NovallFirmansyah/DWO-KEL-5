<?php
require('koneksi.php');

$sql1 = "SELECT dp.ProductCategory AS kategori, 
                dt.Bulan AS bulan, 
                SUM(fs.SalesAmount) AS penjualan
         FROM factsales fs
         JOIN dimproduct dp ON fs.ProductID = dp.ProductID
         JOIN dimtime dt ON fs.TimeID = dt.TimeID
         GROUP BY dp.ProductCategory, dt.Bulan
         ORDER BY dp.ProductCategory, dt.Bulan";

$result1 = mysqli_query($conn, $sql1);

$penjualan = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($penjualan, array(
        "penjualan" => $row['penjualan'],
        "bulan" => $row['bulan'],
        "kategori" => $row['kategori']
    ));
}
$data7 = json_encode($penjualan);
?>