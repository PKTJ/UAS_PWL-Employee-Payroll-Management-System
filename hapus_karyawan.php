<?php
include 'config.php';

$id = $_GET['id'];

// cari id gaji yang berhubungan dengan karyawan ini
$karyawan = $conn->query("SELECT gaji FROM karyawan WHERE id=$id")->fetch_assoc();
$id_gaji = $karyawan['gaji'];

// hapus data karyawan
$conn->query("DELETE FROM karyawan WHERE id=$id");

// hapus data gaji terkait juga
$conn->query("DELETE FROM gaji WHERE id=$id_gaji");

header("Location: tabel_karyawan.php");
?>
