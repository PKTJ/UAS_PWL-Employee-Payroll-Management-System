<?php
include 'config.php';

// Validasi dan ambil ID gaji
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php?page=tabel_karyawan');
    exit;
}

// Ambil data gaji
$stmt = $conn->prepare("SELECT * FROM gaji WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
if (!$data) {
    header('Location: index.php?page=tabel_karyawan');
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cast ke integer
    $pokok    = (int) $_POST['pokok'];
    $lembur   = (int) $_POST['lembur'];
    $pajak    = (int) $_POST['pajak'];
    $asuransi = (int) $_POST['asuransi'];

    $upd = $conn->prepare(
        "UPDATE gaji 
           SET pokok    = ?, 
               lembur   = ?, 
               pajak    = ?, 
               asuransi = ?
         WHERE id = ?"
    );
    // 5 integer parameters → 'iiiii'
    $upd->bind_param(
        'iiiii',
        $pokok,
        $lembur,
        $pajak,
        $asuransi,
        $id
    );
    $upd->execute();

    header('Location: index.php?page=tabel_karyawan');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Gaji</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="css/styleku.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">
      <i class="fa fa-money-bill-wave me-2"></i>Edit Gaji
    </h2>
    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label for="pokok" class="form-label">Gaji Pokok</label>
        <input type="number" step="1" id="pokok" name="pokok" required
               class="form-control"
               value="<?= htmlspecialchars($data['pokok']) ?>">
      </div>
      <div class="col-md-6">
        <label for="lembur" class="form-label">Lembur</label>
        <input type="number" step="1" id="lembur" name="lembur"
               class="form-control"
               value="<?= htmlspecialchars($data['lembur']) ?>">
      </div>
      <div class="col-md-6">
        <label for="pajak" class="form-label">Pajak</label>
        <input type="number" step="1" id="pajak" name="pajak"
               class="form-control"
               value="<?= htmlspecialchars($data['pajak']) ?>">
      </div>
      <div class="col-md-6">
        <label for="asuransi" class="form-label">Asuransi</label>
        <input type="number" step="1" id="asuransi" name="asuransi"
               class="form-control"
               value="<?= htmlspecialchars($data['asuransi']) ?>">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save me-1"></i>Simpan
        </button>
        <a href="index.php?page=tabel_karyawan" class="btn btn-secondary">
          <i class="fa fa-arrow-left me-1"></i>Batal
        </a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

