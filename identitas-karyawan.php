<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_siap";
$connect = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_error()) {
    echo "koneksi database gagal";
}

// Fungsi Tambah Karyawan
if (isset($_POST['add'])) {
    $id_user = $_POST['id_user'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $department = $_POST['department'];
    $jabatan = $_POST['jabatan'];

    $sql = "INSERT INTO tbl_data_karyawan (id_user, nama_karyawan, department, jabatan) VALUES ('$id_user', '$nama_karyawan', '$department', '$jabatan')";
    $conn->query($sql);
    header("Location: {$_SERVER['PHP_SELF']}");
}

// Fungsi Edit Karyawan
if (isset($_POST['edit'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $id_user = $_POST['id_user'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $department = $_POST['department'];
    $jabatan = $_POST['jabatan'];

    $sql = "UPDATE tbl_data_karyawan SET id_user='$id_user', nama_karyawan='$nama_karyawan', department='$department', jabatan='$jabatan' WHERE id_karyawan='$id_karyawan'";
    $conn->query($sql);
    header("Location: {$_SERVER['PHP_SELF']}");
}

// Fungsi Hapus Karyawan
if (isset($_GET['delete'])) {
    $id_karyawan = $_GET['delete'];
    $sql = "DELETE FROM tbl_data_karyawan WHERE id_karyawan='$id_karyawan'";
    $conn->query($sql);
    header("Location: {$_SERVER['PHP_SELF']}");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Data Karyawan</h2>

    <!-- Button Tambah Data -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        Tambah Karyawan
    </button>

    <!-- Tabel Data Karyawan -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Karyawan</th>
                <th>ID User</th>
                <th>Nama Karyawan</th>
                <th>Department</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM tbl_data_karyawan";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_karyawan']}</td>
                    <td>{$row['id_user']}</td>
                    <td>{$row['nama_karyawan']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['jabatan']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editEmployeeModal{$row['id_karyawan']}'>Edit</button>
                        <a href='?delete={$row['id_karyawan']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Delete</a>
                    </td>
                </tr>";

                // Modal Edit
                echo "
                <div class='modal fade' id='editEmployeeModal{$row['id_karyawan']}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <form action='' method='POST'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Edit Karyawan</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <input type='hidden' name='id_karyawan' value='{$row['id_karyawan']}'>
                                    <div class='mb-3'>
                                        <label class='form-label'>ID User</label>
                                        <input type='text' class='form-control' name='id_user' value='{$row['id_user']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label'>Nama Karyawan</label>
                                        <input type='text' class='form-control' name='nama_karyawan' value='{$row['nama_karyawan']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label'>Department</label>
                                        <input type='text' class='form-control' name='department' value='{$row['department']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label'>Jabatan</label>
                                        <input type='text' class='form-control' name='jabatan' value='{$row['jabatan']}' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' name='edit' class='btn btn-primary'>Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ID User</label>
                        <input type="text" class="form-control" name="id_user" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" name="nama_karyawan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <input type="text" class="form-control" name="department" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
