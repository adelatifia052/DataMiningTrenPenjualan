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
                            <a class="nav-link" href="uban.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Uban
                            </a>
                            <a class="nav-link" href="logout.php">LOGOUT</a>
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
                    <div class="container-fluid px-4">
                        <center><h1 class="mt-4">CABANG KIJANG</h1></center>
                        
                        <div class="row">
                            <div class="col-xl-21">
                                <div class="card mb-7">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-7"></i>
                                        Grafik Penjualan
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Data Mining</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

            <?php
            // Baca file CSV
            $filePath = __DIR__ . '/data/cabangkijang.csv'; // Sesuaikan path
            $data = [];
            if (($handle = fopen($filePath, 'r')) !== false) {
                // Lewati header
                $header = fgetcsv($handle, 1000, ',');
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $data[] = [
                        'BULAN' => $row[0],
                        'KIJANG' => (float) $row[1]
                    ];
                }
                fclose($handle);
            }

            // Pisahkan data untuk grafik
            $BULAN = array_column($data, 'BULAN');
            $KIJANG = array_column($data, 'KIJANG');
            ?>

            <script>
            // Data PHP ke JavaScript
            const labels = <?php echo json_encode($BULAN); ?>;
            const kijang = <?php echo json_encode($KIJANG); ?>;

            // Tentukan warna yang berbeda untuk setiap batang
            const colors = [
                'rgba(54, 162, 235, 0.6)', // Biru
                'rgba(255, 99, 132, 0.6)', // Merah
                'rgba(75, 192, 192, 0.6)', // Hijau
                'rgba(255, 159, 64, 0.6)', // Oranye
                'rgba(153, 102, 255, 0.6)' // Ungu
            ];

            // Membuat array warna yang akan dipakai sesuai dengan jumlah data
            const colorArray = Array.from({length: kijang.length}, (v, i) => colors[i % colors.length]);

            // Grafik Bar
            const ctxBar = document.getElementById('myBarChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar', // Ubah ke grafik bar
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Penjualan Cabang Kijang',
                            data: kijang,
                            backgroundColor: colorArray, // Menggunakan array warna
                            borderColor: colorArray.map(color => color.replace('0.6', '1')), // Warna border dengan opasitas penuh
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'NAMA KUE' // Judul sumbu X
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Jumlah Penjualan' // Judul sumbu Y
                            },
                            beginAtZero: true // Mulai dari 0
                        }
                    }
                }
            });
            </script>

    </body>
</html>
