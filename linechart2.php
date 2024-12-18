<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Adventure Works</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/styleGraph.css">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>

<body id="page-top">

<?php 
// Mengambil data dari data7.php
include 'data7.php';
$data7 = json_decode($data7, TRUE);
?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div id="linechart" class="grafik"></div>
                <p class="highcharts-description">
                    Berikut merupakan grafik untuk menampilkan data penjualan bulanan pada setiap kategori.
                </p>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Dashboard DWO Kelompok 5</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Script untuk membuat line chart -->
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Membuat chart
        const chart = Highcharts.chart('linechart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Data Penjualan Bulanan Setiap Kategori Produk'
            },
            subtitle: {
                text: 'Source: Database advuas.sql'
            },
            xAxis: {
                categories: [
                    <?php foreach ($data7 as $item): ?>
                        '<?= $item["bulan"] ?>',
                    <?php endforeach; ?>
                ],
                title: {
                    text: 'Bulan'
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah Penjualan'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [
                <?php 
                // Mengelompokkan data berdasarkan kategori
                $categories = [];
                foreach ($data7 as $data) {
                    $categories[$data['kategori']][] = $data['penjualan'];
                }

                foreach ($categories as $kategori => $penjualanList): ?>{
                        name: '<?= $kategori ?>',
                        data: [<?= implode(',', $penjualanList) ?>],
                        visible: false // Menonaktifkan data secara default
                    },
                <?php endforeach; ?>
            ]
        });

        // Fungsi untuk toggle visibilitas semua seri data
        const toggleData = () => {
            const allVisible = chart.series.every(series => series.visible);
            chart.series.forEach(series => series.setVisible(!allVisible, false));
            chart.redraw();
        };

        // Menambahkan tombol untuk memunculkan/menyembunyikan semua data
        const button = document.createElement('button');
        button.innerHTML = 'Tampilkan/Sembunyikan Semua Data';
        button.classList.add('btn', 'btn-sm', 'btn-primary'); // Ukuran lebih kecil dengan `btn-sm`
        button.style.margin = '10px';
        button.addEventListener('click', toggleData);

        // Menambahkan tombol ke bawah kontainer chart
        const chartContainer = document.querySelector('#linechart');
        const buttonContainer = document.createElement('div');
        buttonContainer.style.textAlign = 'center'; // Posisikan tombol di tengah bawah
        buttonContainer.appendChild(button);
        chartContainer.insertAdjacentElement('afterend', buttonContainer);
    });
</script>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.3/js/sb-admin-2.min.js"></script>

</body>

</html>