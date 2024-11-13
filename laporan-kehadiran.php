<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_siap";
$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$query = "SELECT id_kehadiran, id_karyawan, periode, nama_karyawan, hadir, pulang FROM tbl_kehadiran";
$result = mysqli_query($connect, $query);

$dataPegawai = [];
$kehadiran = [];
$cuti = [];
$lembur = [];
$keterlambatan = [];

while ($row = mysqli_fetch_assoc($result)) {
    $kehadiran[] = $row['id_kehadiran'];
    $kehadiran[] = $row['id_karyawan'];
    $periode[] = $row['periode'];
    $dataPegawai[] = $row['nama_karyawan'];
    $hadir[] = $row['hadir'];
    $pulang[] = $row['pulang'];
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Kehadiran Pegawai</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2>Data Kehadiran Pegawai</h2>
    <canvas id="attendanceChart" width="400" height="200"></canvas>

    <script>
        const dataPegawai = <?php echo json_encode($dataPegawai); ?>;
        const kehadiran = <?php echo json_encode($kehadiran); ?>;
        const cuti = <?php echo json_encode($cuti); ?>;
        const lembur = <?php echo json_encode($lembur); ?>;
        const keterlambatan = <?php echo json_encode($keterlambatan); ?>;

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dataPegawai,
                datasets: [
                    {
                        label: 'Kehadiran',
                        data: kehadiran,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cuti',
                        data: cuti,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Lembur',
                        data: lembur,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Keterlambatan',
                        data: keterlambatan,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
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

