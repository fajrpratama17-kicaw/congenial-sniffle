<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_penghuni = mysqli_real_escape_string($conn, $_GET['id']);

    // Update status pembayaran milik penghuni menjadi lunas
    $query_bayar = "UPDATE tenants SET status_pembayaran = 'lunas' WHERE id = '$id_penghuni'";

    if (mysqli_query($conn, $query_bayar)) {
        header("Location: pembayaran.php?status=sukses_bayar");
        exit();
    } else {
        echo "Gagal memperbarui status pembayaran: " . mysqli_error($conn);
    }
} else {
    header("Location: pembayaran.php");
    exit();
}
?>