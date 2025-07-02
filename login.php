<?php
session_start();
require 'config.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    if (!$password) $errors[] = 'Password required';

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, password FROM user WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // Regenerate session ID untuk keamanan
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;
            
            // Gunakan absolute URL untuk redirect yang lebih reliable
            $redirect_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
            header('Location: ' . $redirect_url);
            
            // Fallback dengan JavaScript jika header redirect gagal
            echo "<script>window.location.href = 'index.php';</script>";
            exit;
        } else {
            $errors[] = 'Email atau password salah';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Login</h2>
    <?php if (!empty($_GET['registered'])) echo '<p class="success">Pendaftaran berhasil! Silahkan login.</p>';?>
    <?php if ($errors): ?>
        <div class="error-box">
            <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Belum mempunyai akun? <a href="register.php">Daftar disini</a></p>
</div>

<script>
// Tambahan JavaScript untuk memastikan redirect berhasil
if (window.location.search.includes('login_success=1')) {
    window.location.href = 'index.php';
}
</script>
</body>
</html>