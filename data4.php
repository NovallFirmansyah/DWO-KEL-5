<?php
require 'koneksi.php';

$sql = "SELECT f.productcategory AS kategori,
               COUNT(DISTINCT fp.CustomerID) AS pelanggan
        FROM dimproduct f
        JOIN factsales fp ON f.productID = fp.productID
        GROUP BY f.productcategory
        ORDER BY pelanggan DESC";

$result = mysqli_query($conn, $sql);

$hasil = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($hasil, array(
        "kategori" => $row['kategori'],
        "pelanggan" => $row['pelanggan'],
    ));
}

$data4 = json_encode($hasil);