<?php
require('koneksi.php');

$sql = "SELECT s.territoryname AS nama_toko, 
               SUM(fp.SalesAmount) AS total_pendapatan
        FROM dimsalesterritory s
        JOIN factsales fp ON s.territoryid = fp.territoryid
        GROUP BY s.territoryname
        ORDER BY total_pendapatan DESC";

$result = mysqli_query($conn, $sql);

$hasil = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($hasil, array(
        "name" => $row['nama_toko'], // Gunakan alias dari query
        "total" => $row['total_pendapatan']
    ));
}

$data = json_encode($hasil);


?>
