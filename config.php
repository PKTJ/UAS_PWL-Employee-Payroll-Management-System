<?php
//session_start();                              

// Koneksi MySQLi (jika masih dipakai)
$host    = 'localhost';
$user    = 'root';
$pass    = '';
$dbname  = 'gaji_db';
$conn    = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Koneksi PDO
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Helper untuk proteksi halaman
if (!function_exists('ensure_logged_in')) {
    function ensure_logged_in() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }
    }
}
?>
