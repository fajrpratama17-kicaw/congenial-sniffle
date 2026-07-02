<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk mencari user dengan role admin
    $query_user = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'";
    $result_user = mysqli_query($conn, $query_user);

    if (mysqli_num_rows($result_user) === 1) {
        // Jika ketemu, buat session login sukses
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        header("Location: index.php");
        exit();
    } else {
        // Jika salah, kembalikan ke login.php dengan pesan gagal
        header("Location: login.php?pesan=gagal");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>