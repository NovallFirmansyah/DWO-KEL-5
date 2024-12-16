<?php
require('koneksi.php');

$sql1 = "SELECT p.productcategory, 
                t.bulan, 
                SUM(fp.SalesAmount) AS pendapatan
         FROM dimproduct p
         JOIN factsales fp ON p.productID = fp.productID
         JOIN dimtime t ON fp.timeID = t.timeID
         GROUP BY p.productcategory, t.bulan";

$sql2 = "SELECT p.productcategory, 
                SUM(fp.SalesAmount) AS pembagi
         FROM dimproduct p
         JOIN factsales fp ON p.productID = fp.productID
         GROUP BY p.productcategory";

$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

$pendapatan = array();
$pembagi = array();

while ($row = mysqli_fetch_array($result1)) {
    array_push($pendapatan, array(
        "pendapatan" => $row['pendapatan'],
        "bulan" => $row['bulan'],
        "kategori" => $row['productcategory']
    ));
}

while ($row = mysqli_fetch_array($result2)) {
    array_push($pembagi, array(
        "kategori" => $row['productcategory'],
        "pembagi" => $row['pembagi']
    ));
}

function countPersen($nilai, $pembagi) {
    return $nilai / $pembagi * 100;
}

$hasil = array();
foreach ($pembagi as $item) {
    foreach ($pendapatan as $dapat) {
        if ($item["kategori"] == $dapat["kategori"]) {
            array_push($hasil, array(
                "kategori" => $dapat['kategori'],
                "persen" => countPersen(floatval($dapat["pendapatan"]), floatval($item["pembagi"])),
                "bulan" => $dapat['bulan']
            ));
        }
    }
}

$data6 = json_encode($hasil);
?>