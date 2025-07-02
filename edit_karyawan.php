<?php
include 'config.php';

// Validasi dan ambil ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?page=karyawan');
    exit;
}

// Ambil data tabel_karyawan
$stmt = $conn->prepare("SELECT * FROM karyawan WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) {
    header('Location: index.php?page=karyawan');
    exit;
}

// Proses POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama          = trim($_POST['nama']);
    $kelamin       = $_POST['kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $email         = trim($_POST['email']);
    $telephone     = trim($_POST['telephone']);

    $upd = $conn->prepare(
        "UPDATE karyawan SET 
            nama = ?,
            kelamin = ?,
            tanggal_lahir = ?,
            email = ?,
            telephone = ?
         WHERE id = ?"
    );
    $upd->bind_param('sssssi', $nama, $kelamin, $tanggal_lahir, $email, $telephone, $id);
    $upd->execute();

    header('Location: index.php?page=karyawan');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="css/styleku.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4"><i class="fa fa-user-edit me-2"></i>Edit Karyawan</h2>
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" id="nama" name="nama" class="form-control" required
               value="<?= htmlspecialchars($data['nama']) ?>">
      </div>
      <div class="col-md-6">
        <label for="kelamin" class="form-label">Kelamin</label>
        <select id="kelamin" name="kelamin" class="form-select" required>
          <option value="Laki-laki" <?= $data['kelamin']==='Laki-laki'?'selected':'' ?>>Laki-laki</option>
          <option value="Perempuan" <?= $data['kelamin']==='Perempuan'?'selected':'' ?>>Perempuan</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required
               value="<?= htmlspecialchars($data['tanggal_lahir']) ?>">
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required
               value="<?= htmlspecialchars($data['email']) ?>">
      </div>
      <div class="col-md-6">
        <label for="telephone" class="form-label">Telephone</label>
        <input type="text" id="telephone" name="telephone" class="form-control" required
               value="<?= htmlspecialchars($data['telephone']) ?>">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save me-1"></i>Simpan
        </button>
        <a href="index.php?page=karyawan" class="btn btn-secondary">
          <i class="fa fa-arrow-left me-1"></i>Batal
        </a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
