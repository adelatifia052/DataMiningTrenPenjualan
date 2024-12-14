<?php
// Proses file CSV
$labels = [];
$data_kijang = [];
$data_tanjungpinang = [];
$data_uban = [];

if (($handle = fopen("jumlahdatacabang.csv", "r")) !== FALSE) {
    $row = 0;
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row === 0 || $row === 1) {
            // Skip the header rows
            $row++;
            continue;
        }

        // Ambil data dari setiap kolom
        $labels[] = $data[0]; // Kolom bulan
        $data_kijang[] = (int)$data[1]; // Cabang Kijang
        $data_tanjungpinang[] = (int)$data[2]; // Cabang Tanjungpinang
        $data_uban[] = (int)$data[3]; // Cabang Uban

        $row++;
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Data CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Grafik Penjualan per Cabang</h2>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Grafik Penjualan</h5>
            </div>
            <div class="card-body">
                <canvas id="branchChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Data dari PHP
        const labels = <?php echo json_encode($labels); ?>;
        const dataKijang = <?php echo json_encode($data_kijang); ?>;
        const dataTanjungpinang = <?php echo json_encode($data_tanjungpinang); ?>;
        const dataUban = <?php echo json_encode($data_uban); ?>;

        // Membuat grafik menggunakan Chart.js
        const ctx = document.getElementById('branchChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Jenis grafik
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'KIJANG',
                        data: dataKijang,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'TANJUNGPINANG',
                        data: dataTanjungpinang,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'UBAN',
                        data: dataUban,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
