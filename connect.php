<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_siap";
$connect = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_error()) {
    echo "koneksi database gagal";
}
?>
