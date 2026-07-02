<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil data total, terisi, dan kosong
$total_kamar = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM rooms"));
$kamar_terisi = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM rooms WHERE status='terisi'"));
$kamar_kosong = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM rooms WHERE status='kosong'"));

// Ambil data penghuni aktif
$query_penghuni = "SELECT tenants.nama_lengkap, tenants.no_hp, tenants.tanggal_masuk, rooms.nomor_kamar 
                   FROM tenants 
                   LEFT JOIN rooms ON tenants.room_id = rooms.id";
$result_penghuni = mysqli_query($conn, $query_penghuni);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Jersey Kos (Admin)</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-bar"></div>
            <span>Jersey Kos</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="active"><i class="fas fa-home"></i> &nbsp;Dashboard</a>
            <a href="kamar.php"><i class="fas fa-bed"></i> &nbsp;Kamar</a>
            <a href="tambah_penghuni.php"><i class="fas fa-users"></i> &nbsp;Penghuni</a>
            <a href="pembayaran.php"><i class="fas fa-money-bill-wave"></i> &nbsp;Pembayaran</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> &nbsp;Keluar</a>
        </nav>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="header">
            <h1><div class="title-bar"></div> Dasbor Manajemen Kos</h1>
            <p class="subtitle">Halo, Admin. Berikut ringkasan status kos untuk tanggal <?php echo date('d F Y'); ?>.</p>
        </div>

        <div class="cards-container">
            <div class="card">
                <i class="fas fa-building card-icon"></i>
                <div class="card-title">Total Kamar Inventaris</div>
                <div class="card-value"><?php echo $total_kamar; ?></div>
                <p class="card-description">Seluruh unit kamar yang tersedia untuk disewakan dalam sistem.</p>
            </div>
            <div class="card">
                <i class="fas fa-user-check card-icon"></i>
                <div class="card-title">Kamar Terisi</div>
                <div class="card-value"><?php echo $kamar_terisi; ?></div>
                <p class="card-description">Unit kamar yang sedang ditempati oleh penghuni aktif.</p>
            </div>
            <div class="card">
                <i class="fas fa-door-open card-icon"></i>
                <div class="card-title">Kamar Kosong</div>
                <div class="card-value"><?php echo $kamar_kosong; ?></div>
                <p class="card-description">Unit kamar yang siap untuk disewakan segera kepada penghuni baru.</p>
            </div>
        </div>

        <!-- Tabel Data Penghuni -->
        <div class="table-container">
            <div class="table-header">
                <h2>Daftar Penghuni Kos Aktif</h2>
                <a href="tambah_penghuni.php" class="btn-add" style="text-decoration: none;"><i class="fas fa-plus"></i> &nbsp;Tambah Penghuni</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>No. Kamar</th>
                        <th>No. HP</th>
                        <th>Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_penghuni) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_penghuni)): ?>
                            <tr>
                                <td style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td><span class="badge-room"><?php echo htmlspecialchars($row['nomor_kamar']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_masuk'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">Belum ada data penghuni kos saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>