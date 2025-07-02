<?php
// home.php
require 'config.php';
ensure_logged_in();

// Ambil data statistik
// 1. Jumlah karyawan
$stmt = $pdo->query("SELECT COUNT(*) FROM karyawan");
$totalEmployees = $stmt->fetchColumn();

// 2. Total net gaji
$stmt = $pdo->query("
    SELECT SUM(g.pokok + g.lembur - g.pajak - g.asuransi)
    FROM karyawan k
    JOIN gaji g ON k.gaji = g.id
");
$totalPayroll = $stmt->fetchColumn();

// 3. Data karyawan terbaru (5)
$stmt = $pdo->query("
    SELECT nama, DATE_FORMAT(tanggal_lahir, '%d %b %Y') AS dob
    FROM karyawan
    ORDER BY id DESC
    LIMIT 5
");
$newHires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Hover animation untuk statistik card */
    .stats-card {
      transition: transform .3s, box-shadow .3s;
      cursor: pointer;
    }
    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- sidebar -->
    <div class="flex-grow-1 p-4">
      <h1>Selamat datang di Dashboard</h1>

      <!-- Statistik Card -->
      <div class="card stats-card my-4 p-3">
        <div class="row">
          <div class="col-md-4">
            <h5>Karyawan Terdaftar</h5>
            <p class="display-6"><?= $totalEmployees ?></p>
          </div>
          <div class="col-md-8">
            <h5>Total Net Gaji</h5>
            <p class="display-6">Rp <?= number_format($totalPayroll, 0, ',', '.') ?></p>
          </div>
        </div>
      </div>

      <!-- Assets Tambahan -->
      <div class="row g-4">
        <!-- 1. Chart Distribusi Gender -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              Distribusi Gender
            </div>
            <div class="card-body">
              <canvas id="genderChart"></canvas>
            </div>
          </div>
        </div>

        <!-- 2. Daftar Karyawan Terbaru -->
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              5 Karyawan Terbaru
            </div>
            <ul class="list-group list-group-flush">
            <?php foreach($newHires as $k): ?>
              <li class="list-group-item d-flex justify-content-between">
                <?= htmlspecialchars($k['nama']) ?>
                <small class="text-muted"><?= $k['dob'] ?></small>
              </li>
            <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <!-- 3. Quick Links -->
        <div class="col-12">
          <div class="card p-3">
            <h5>Quick Links</h5>
            <div class="btn-group" role="group">
              <a href="?page=karyawan" class="btn btn-outline-primary">Data Karyawan</a>
              <a href="?page=tabel_karyawan" class="btn btn-outline-success">Data Gaji</a>
              <a href="?page=laporan" class="btn btn-outline-warning">Laporan</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap 5 JS & dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script Chart.js -->
  <script>
    // Ambil data gender via PHP
    <?php
      $g = $pdo->query("SELECT kelamin, COUNT(*) AS cnt FROM karyawan GROUP BY kelamin")
               ->fetchAll(PDO::FETCH_KEY_PAIR);
      $male = $g['Laki-laki'] ?? 0;
      $female = $g['Perempuan'] ?? 0;
      $genderData = [
        'labels' => ['Laki-laki', 'Perempuan'],
        'datasets' => [[
          'data' => [$male, $female]
        ]]
      ];
    ?>
    const genderData = <?= json_encode($genderData); ?>;

    new Chart(document.getElementById('genderChart'), {
      type: 'pie',
      data: {
        labels: genderData.labels,
        datasets: [{
          data: genderData.datasets[0].data
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  </script>
</body>
</html>
