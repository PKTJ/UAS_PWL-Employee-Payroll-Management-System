<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <?php

  $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
  ?>
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
    }
    .main-container {
      display: flex;
      height: 100vh;
    }
    .sidebar { 
      width: 250px; 
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }
    .content-wrapper {
      margin-left: 250px;
      height: 100vh;
      overflow-y: auto;
      flex: 1;
    }
    .nav-link {
      transition: all 0.3s ease;
      border-radius: 8px;
      margin-bottom: 4px;
      position: relative;
      overflow: hidden;
    }
    .nav-link:hover {
      background-color: rgba(255,255,255,0.15) !important;
      transform: translateX(5px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .nav-link.active {
      background-color: rgba(255,255,255,0.2) !important;
      border-left: 4px solid #0d6efd;
      font-weight: 600;
    }
    .nav-link.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: linear-gradient(45deg, #0d6efd, #6610f2);
      animation: activeGlow 2s infinite alternate;
    }
    @keyframes activeGlow {
      0% { opacity: 0.7; }
      100% { opacity: 1; }
    }
    .nav-link i {
      transition: transform 0.3s ease;
    }
    .nav-link:hover i {
      transform: scale(1.1);
    }
    .btn-outline-light {
      transition: all 0.3s ease;
    }
    .btn-outline-light:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
  </style>
</head>
<body>
  <div class="main-container">
    <nav class="sidebar bg-dark text-white p-3">
      <h2 class="h4 text-primary mb-4"><i class="fas fa-hamburger me-2"></i>MyApp</h2>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item mb-2">
          <a href="?page=home" class="nav-link text-white <?= $current_page === 'home' ? 'active' : '' ?>">
            <i class="fas fa-home me-2"></i>Home
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="?page=karyawan" class="nav-link text-white <?= $current_page === 'karyawan' ? 'active' : '' ?>">
            <i class="fas fa-users me-2"></i>Data Karyawan
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="?page=tabel_karyawan" class="nav-link text-white <?= $current_page === 'tabel_karyawan' ? 'active' : '' ?>">
            <i class="fas fa-coins me-2"></i>Data Gaji
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="?page=laporan" class="nav-link text-white <?= $current_page === 'laporan' ? 'active' : '' ?>">
            <i class="fas fa-file-alt me-2"></i>Laporan
          </a>
        </li>
      </ul>
      
      <div class="mt-auto">
        <a href="logout.php" class="btn btn-outline-light w-100" onclick="return confirm('Yakin ingin logout?')">
          <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
      </div>
    </nav>
    
    <div class="content-wrapper">
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link:not(.btn)');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Hapus active dari semua link
                navLinks.forEach(l => l.classList.remove('active'));
                
                // Tambahkan active ke link yang diklik
                this.classList.add('active');
                
                // Tambahkan loading effect
                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fas fa-spinner fa-spin me-2';
                
                // Restore icon setelah delay
                setTimeout(() => {
                    icon.className = originalClass;
                }, 500);
            });
        });
        
        // Smooth scroll untuk content area
        const contentArea = document.querySelector('.content-wrapper');
        if (contentArea) {
            contentArea.style.opacity = '0';
            setTimeout(() => {
                contentArea.style.transition = 'opacity 0.3s ease';
                contentArea.style.opacity = '1';
            }, 100);
        }
    });
    </script>
