<?php
$host = "sql207.infinityfree.com";
$user = "if0_43103843";
$pass = "d12012008mdn"; // Password akun hosting InfinityFree kamu
$db   = "if0_43103843_luminastore";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>