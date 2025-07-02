<?php
require 'config.php';     
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validasi
    if (!$username)                             $errors[] = 'Username required';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    if (strlen($password) < 6)                 $errors[] = 'Password minimal 6 karakter';
    if ($password !== $confirm)                $errors[] = 'Password dan konfirmasi tidak cocok';

    // Cek email unik
    $stmt = $pdo->prepare('SELECT id FROM user WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch())                        $errors[] = 'Email sudah terdaftar';

    // Jika tidak ada error, simpan
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare(
          'INSERT INTO user (username, email, password) VALUES (?, ?, ?)'
        );
        $stmt->execute([$username, $email, $hash]);
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Register</h2>
    <?php if ($errors): ?>
        <div class="error-box">
            <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>