<?php
require 'config.php';
ensure_logged_in();
// Data sudah tersedia dari index.php yang sudah include config.php
?>
<div class="container-fluid">
  <h1 class="mb-4">Laporan Karyawan</h1>

  <div class="d-flex mb-3">
    <input
      type="text"
      id="search"
      class="form-control me-2"
      placeholder="Cari Karyawan..."
    />
    <button
      id="exportPdf"
      class="btn btn-danger"
    >
      <i class="fas fa-file-pdf me-1"></i> Export PDF
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Kelamin</th>
          <th>Tgl. Lahir</th>
          <th>Email</th>
          <th>Telepon</th>
          <th>Pokok</th>
          <th>Lembur</th>
          <th>Pajak</th>
          <th>Asuransi</th>
          <th>Total Gaji</th>
        </tr>
      </thead>
      <tbody id="table-body">
        <?php
        // Load semua data awal
        $sql = "
          SELECT k.id, k.nama, k.kelamin, k.tanggal_lahir,
                 k.email, k.telephone,
                 g.pokok, g.lembur, g.pajak, g.asuransi,
                 (g.pokok + g.lembur - g.pajak - g.asuransi) AS total
          FROM karyawan k
          LEFT JOIN gaji g ON k.gaji = g.id
        ";
        $res = $conn->query($sql);
        while ($row = $res->fetch_assoc()):
        ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['nama']) ?></td>
          <td><?= htmlspecialchars($row['kelamin']) ?></td>
          <td><?= $row['tanggal_lahir'] ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['telephone']) ?></td>
          <td><?= number_format($row['pokok'],2,',','.') ?></td>
          <td><?= number_format($row['lembur'],2,',','.') ?></td>
          <td><?= number_format($row['pajak'],2,',','.') ?></td>
          <td><?= number_format($row['asuransi'],2,',','.') ?></td>
          <td><?= number_format($row['total'],2,',','.') ?></td>
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
          <td>${parseFloat(item.pokok).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
          <td>${parseFloat(item.lembur).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
          <td>${parseFloat(item.pajak).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
          <td>${parseFloat(item.asuransi).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
          <td>${parseFloat(item.total).toLocaleString('id-ID', {minimumFractionDigits:2})}</td>
        `;
        tbody.appendChild(tr);
      });
    });
});

// Tombol export PDF dengan filter keyword
document.getElementById('exportPdf').addEventListener('click', function() {
  const keyword = document.getElementById('search').value;
  window.location.href = 'models/export_pdf.php?keyword=' + encodeURIComponent(keyword);
});
</script>