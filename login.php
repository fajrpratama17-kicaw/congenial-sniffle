<?php
session_start();
// Jika admin sudah login sebelumnya, langsung lempar ke dashboard index.php
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SmartKos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="login-body">

    <div class="login-card">
        <div class="login-header">
            <h2>Admin Login</h2>
            <p>321 Chancellor Ave, Newark, NJ 07112.</p>
        </div>

        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px; text-align: center;">
                <i class="fas fa-exclamation-circle"></i> Username atau Password salah!
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-submit" style="width: 100%; margin-top: 12px; padding: 14px;">Masuk Aplikasi</button>
        </form>
    </div>

</body>
</html>