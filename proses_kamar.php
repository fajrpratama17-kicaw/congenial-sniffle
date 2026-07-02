<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_kamar   = mysqli_real_escape_string($conn, $_POST['nomor_kamar']);
    $tipe_kamar    = mysqli_real_escape_string($conn, $_POST['tipe_kamar']);
    $harga_bulanan = mysqli_real_escape_string($conn, $_POST['harga_bulanan']);

    // 1. Validasi dulu apakah nomor kamar tersebut sudah terdaftar di database
    $cek_kamar = mysqli_query($conn, "SELECT id FROM rooms WHERE nomor_kamar = '$nomor_kamar'");
    if (mysqli_num_rows($cek_kamar) > 0) {
        echo "<script>alert('Error: Nomor kamar $nomor_kamar sudah terdaftar!'); window.location='kamar.php';</script>";
        exit();
    }

    // 2. Jika aman, insert ke database (default status: 'kosong')
    $query_insert_kamar = "INSERT INTO rooms (nomor_kamar, tipe_kamar, harga_bulanan, status) 
                           VALUES ('$nomor_kamar', '$tipe_kamar', '$harga_bulanan', 'kosong')";
    
    if (mysqli_query($conn, $query_insert_kamar)) {
        header("Location: kamar.php?status=sukses_tambah");
        exit();
    } else {
        echo "Gagal menambahkan kamar: " . mysqli_error($conn);
    }
} else {
    header("Location: kamar.php");
    exit();
}
?>