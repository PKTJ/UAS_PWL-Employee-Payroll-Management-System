<?php
require 'config.php';
ensure_logged_in();
// Ambil semua pengguna dari tabel karyawan
$result = $conn->query("SELECT * FROM karyawan");
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Karyawan</h2>
        <a class="btn btn-success" href="create_karyawan.php">
            <i class="fa fa-plus me-1"></i> Tambah Pengguna
        </a>
    </div>
    <!-- Live Search Input -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Cari karyawan...">
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['kelamin']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['telephone']) ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="edit_karyawan.php?id=<?= $row['id'] ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="hapus_karyawan.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data?')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// AJAX live search
document.getElementById('search').addEventListener('keyup', function() {
  const keyword = this.value;
  fetch('controller/search_karyawan.php?keyword=' + encodeURIComponent(keyword))
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById('table-body');
      tbody.innerHTML = '';
      data.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${item.id}</td>
          <td>${item.nama}</td>
          <td>${item.kelamin}</td>
          <td>${item.tanggal_lahir}</td>
          <td>${item.email}</td>
          <td>${item.telephone}</td>
          <td>
            <a class="btn btn-primary btn-sm" href="edit_karyawan.php?id=${item.id}">
              <i class="fa fa-edit"></i>
            </a>
            <a class="btn btn-danger btn-sm" href="hapus_karyawan.php?id=${item.id}" onclick="return confirm('Hapus data?')">
              <i class="fa fa-trash"></i>
            </a>
          </td>
        `;
        tbody.appendChild(tr);
      });
    });
});
</script>
