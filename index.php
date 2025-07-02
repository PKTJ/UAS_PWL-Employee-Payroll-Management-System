<?php
session_start();
require 'config.php';
ensure_logged_in(); 

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed = ['home','karyawan','laporan','tabel_karyawan'];
if (!in_array($page, $allowed)) {
  $page = 'home';
}

//bagian ini yang penting jangan kehapus bjir
include 'head.php';
?>
      <div class="p-4">
        <?php
          include $page . '.php';
        ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
