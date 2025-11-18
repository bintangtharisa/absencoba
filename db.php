<?php
$host = "localhost";   // server database
$user = "root";        // username default XAMPP
$pass = "";            // password default XAMPP (kosong)
$db   = "absen";       // nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

// jika gagal
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
