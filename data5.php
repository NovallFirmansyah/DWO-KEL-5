<?php
require('koneksi.php');

$sql = "SELECT p.productcategory AS kategori, 
            SUM(fp.SalesAmount) AS total, 
            (SUM(fp.Salesamount) / (SELECT SUM(SalesAmount) FROM factsales)) * 100 AS persentase
            FROM dimproduct p 
            JOIN factsales fp ON p.productID = fp.productID
            GROUP BY p.productcategory";
$result = mysqli_query($conn, $sql);

$hasil = array();

while ($row = mysqli_fetch_array($result)) {
array_push($hasil, array(
"name" => $row['kategori'],
"total" => $row['total'],
"y" => $row['persentase']
));
}

$data5 = json_encode($hasil);
?>