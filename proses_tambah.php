<?php
session_start();
include 'koneksi.php';

// Cek apakah data dikirim dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap  = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $no_hp         = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $room_id       = mysqli_real_escape_string($conn, $_POST['room_id']);
    $tanggal_masuk = mysqli_real_escape_string($conn, $_POST['tanggal_masuk']);

    // 1. Jalankan query untuk memasukkan data ke tabel 'tenants'
    $query_insert = "INSERT INTO tenants (nama_lengkap, no_hp, room_id, tanggal_masuk) 
                     VALUES ('$nama_lengkap', '$no_hp', '$room_id', '$tanggal_masuk')";
    
    if (mysqli_query($conn, $query_insert)) {
        
        // 2. Jika berhasil, update status kamar tersebut di tabel 'rooms' menjadi 'terisi'
        $query_update_kamar = "UPDATE rooms SET status = 'terisi' WHERE id = '$room_id'";
        mysqli_query($conn, $query_update_kamar);

        // 3. Alihkan halaman kembali ke Dashboard (index.php) dengan status sukses
        header("Location: index.php?status=sukses");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
} else {
    // Jika diakses ilegal tanpa form, kembalikan ke index
    header("Location: index.php");
    exit();
}
?>