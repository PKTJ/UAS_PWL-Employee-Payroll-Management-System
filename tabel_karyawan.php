<?php
include 'config.php';
$result = $conn->query("SELECT 
    karyawan.id,
    karyawan.nama,
    karyawan.kelamin,
    karyawan.telephone,
    gaji.id AS id_gaji,
    gaji.pokok + gaji.lembur - gaji.pajak - gaji.asuransi AS total_gaji
FROM karyawan
LEFT JOIN gaji ON karyawan.gaji = gaji.id
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h2>Data Karyawan</h2>
    <table class="table table-bordered table-hover">
      <thead class="thead-light">
        <tr>
          <th>Nama</th>
          <th>Kelamin</th>
          <th>Telepon</th>
          <th>Total Gaji</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['kelamin']) ?></td>
          <td><?= htmlspecialchars($row['telephone']) ?></td>
          <td><?= number_format($row['total_gaji'],2,',','.') ?></td>
          <td>
            <a href="edit_gaji.php?id=<?= $row['id_gaji'] ?>" class="btn btn-sm btn-info">
              <i class="fa fa-money-bill-wave"></i> Edit Gaji
            </a>
            <a href="hapus_karyawan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau menghapus karyawan ini?');">
              <i class="fa fa-trash"></i> Hapus
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
