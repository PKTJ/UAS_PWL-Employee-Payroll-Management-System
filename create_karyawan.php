<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kelamin = $_POST['kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    // 1. insert gaji default
    $conn->query("INSERT INTO gaji (pokok, lembur, pajak, asuransi) VALUES (0,0,0,0)");
    $id_gaji_baru = $conn->insert_id;

    // 2. insert karyawan
    $sql = "INSERT INTO karyawan 
        (nama, kelamin, tanggal_lahir, email, telephone, gaji) 
        VALUES 
        ('$nama', '$kelamin', '$tanggal_lahir', '$email', '$telephone', '$id_gaji_baru')";
    $conn->query($sql);

    header("Location: tabel_karyawan.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="form-container">
        <h2>Tambah Karyawan</h2>
        <form method="POST">
            Nama: <input class="form-control" type="text" name="nama" required><br>
            Kelamin:
            <select class="form-control" name="kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select><br>
            Tanggal Lahir: <input class="form-control" type="date" name="tanggal_lahir" required><br>
            Email: <input class="form-control" type="email" name="email" required><br>
            Telephone: <input class="form-control" type="text" name="telephone" required><br>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>