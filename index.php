<?php
// Panggil koneksi database
require 'function.php';
require 'cek.php';


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Analisis</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Versi terbaru Chart.js -->
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">PINANG PALEO</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Penjualan
                            </a>
                        
                            <a class="nav-link" href="kijang.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kijang
                            </a>

                            <a class="nav-link" href="tanjungpinang.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tanjungpinang
                            </a>

                            <a class="nav-link" href="kijang.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Uban
                            </a>

                            <a class="nav-link" href="logout.php">
                                LOGOUT
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        PINANG PALEO
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-7">
                        <center><h1 class="mt-4">Grafik Penjualan 3 Cabang Pinang PALEO</h1></center>
                        <center><h2 class="mt-4">September 2023 - September 2024</h2></center>
                        
                        <div class="row">
                            <div class="col-xl-20">
                                <div class="card mb-7">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-7"></i>
                                        Grafik Penjualan
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Data Mining</div>
                           
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <?php
        // Baca file CSV
        $filePath = __DIR__ . '/data/jumlahdatacabang.csv'; // Sesuaikan path
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lewati header
            $header = fgetcsv($handle, 1000, ',');
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data[] = [
                    'BULAN' => $row[0],
                    'KIJANG' => (float) $row[1],
                    'TANJUNGPINANG' => (float) $row[2],
                    'UBAN' => (float) $row[3]
                ];
            }
            fclose($handle);
        }

        // Pisahkan data untuk grafik
        $BULAN = array_column($data, 'BULAN');
        $KIJANG = array_column($data, 'KIJANG');
        $TANJUNGPINANG = array_column($data, 'TANJUNGPINANG');
        $UBAN = array_column($data, 'UBAN');
        ?>

        <script>
            // Data PHP ke JavaScript
            const labels = <?php echo json_encode($BULAN); ?>;
            const kijang = <?php echo json_encode($KIJANG); ?>;
            const tanjungpinang = <?php echo json_encode($TANJUNGPINANG); ?>;
            const uban = <?php echo json_encode($UBAN); ?>;

            // Grafik Area
            const ctxArea = document.getElementById('myAreaChart').getContext('2d');
            new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Kijang',
                            data: kijang,
                            backgroundColor: 'rgba(231, 43, 43, 0.2)',
                            borderColor: 'rgb(155, 4, 4)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tanjungpinang',
                            data: tanjungpinang,
                            backgroundColor: 'rgba(17, 151, 13, 0.2)',
                            borderColor: 'rgb(33, 139, 19)',
                            borderWidth: 1
                        },
                        {
                            label: 'Uban',
                            data: uban,
                            backgroundColor: 'rgba(2, 0, 107, 0.2)',
                            borderColor: 'rgb(11, 102, 145)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            });

            

            
       
        </script>
    </body>
</html>
