
<?php
// Konfigurasi database
$host = 'localhost';
$db = 'db_siap';
$user = 'root';
$pass = '';

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $hari = $_POST['hari'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    
    $sql = "INSERT INTO tbl_jadwal_kerja (nama, hari, jam_masuk, jam_keluar) VALUES ('$nama', '$hari', '$jam_masuk', '$jam_keluar')";
    $conn->query($sql);
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $hari = $_POST['hari'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    
    $sql = "UPDATE tbl_jadwal_kerja SET nama='$nama', hari='$hari', jam_masuk='$jam_masuk', jam_keluar='$jam_keluar' WHERE id=$id";
    $conn->query($sql);
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tbl_jadwal_kerja WHERE id=$id";
    $conn->query($sql);
}

// Ambil data
$data = $conn->query("SELECT * FROM tbl_jadwal_kerja");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kerja</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Jadwal Kerja</h1>

        <div class="row">
                        <!-- Tombol di bagian kanan -->
                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <!-- Tombol Print -->
                            <button onclick="window.print()" class="btn btn-primary">Print</button>

                            <!-- Tombol Export to PDF -->
                            <button onclick="exportToPDF()" class="btn btn-danger">Export to PDF</button>

                            <!-- Tombol Export to Excel -->
                            <button onclick="exportToExcel()" class="btn btn-success">Export to Excel</button>
                        </div>
                    </div>

        <!-- Form Tambah dan Update -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <?php echo isset($_GET['edit']) ? 'Edit Data' : 'Tambah Data'; ?>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required value="<?php echo isset($row['nama']) ? $row['nama'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <input type="text" name="hari" class="form-control" required value="<?php echo isset($row['hari']) ? $row['hari'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" required value="<?php echo isset($row['jam_masuk']) ? $row['jam_masuk'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Keluar</label>
                        <input type="time" name="jam_keluar" class="form-control" required value="<?php echo isset($row['jam_keluar']) ? $row['jam_keluar'] : ''; ?>">
                    </div>
                    <button type="submit" name="<?php echo isset($row['id']) ? 'update' : 'tambah'; ?>" class="btn btn-<?php echo isset($row['id']) ? 'warning' : 'success'; ?>">
                        <?php echo isset($row['id']) ? 'Update' : 'Tambah'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                Daftar Jadwal Kerja
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['hari']; ?></td>
                            <td><?php echo $row['jam_masuk']; ?></td>
                            <td><?php echo $row['jam_keluar']; ?></td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
