<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil data penghuni, kamar, dan status pembayaran mereka
$query_pembayaran = "SELECT tenants.id, tenants.nama_lengkap, tenants.status_pembayaran, rooms.nomor_kamar, rooms.harga_bulanan 
                     FROM tenants 
                     LEFT JOIN rooms ON tenants.room_id = rooms.id";
$result_pembayaran = mysqli_query($conn, $query_pembayaran);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pembayaran - SmartKos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-bar"></div>
            <span>SmartKos</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php"><i class="fas fa-home"></i> &nbsp;Dashboard</a>
            <a href="kamar.php"><i class="fas fa-bed"></i> &nbsp;Kamar</a>
            <a href="tambah_penghuni.php"><i class="fas fa-users"></i> &nbsp;Penghuni</a>
            <a href="pembayaran.php" class="active-menu"><i class="fas fa-money-bill-wave"></i> &nbsp;Pembayaran</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> &nbsp;Keluar</a>
        </nav>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="header">
            <h1><div class="title-bar"></div> Pencatatan Pembayaran</h1>
            <p class="subtitle">Pantau tagihan bulanan penghuni kos dan konfirmasi pembayaran yang masuk.</p>
        </div>

        <!-- Tabel Data Pembayaran -->
        <div class="table-container">
            <div class="table-header">
                <h2>Status Tagihan Bulan Ini (<?php echo date('F Y'); ?>)</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Penghuni</th>
                        <th>No. Kamar</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_pembayaran) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_pembayaran)): ?>
                            <tr>
                                <td style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td><span class="badge-room">Kamar <?php echo htmlspecialchars($row['nomor_kamar']); ?></span></td>
                                <td style="font-weight: 500;">Rp <?php echo number_format($row['harga_bulanan'], 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Cek Status Pembayaran -->
                                    <?php if(isset($row['status_pembayaran']) && $row['status_pembayaran'] == 'lunas'): ?>
                                        <span class="status-pay lunas"><i class="fas fa-check-circle"></i> Lunas</span>
                                    <?php else: ?>
                                        <span class="status-pay belum"><i class="fas fa-exclamation-circle"></i> Belum Bayar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(!isset($row['status_pembayaran']) || $row['status_pembayaran'] != 'lunas'): ?>
                                        <a href="proses_bayar.php?id=<?php echo $row['id']; ?>" class="btn-pay" onclick="return confirm('Konfirmasi pembayaran untuk penghuni ini?')"><i class="fas fa-receipt"></i> Set Lunas</a>
                                    <?php else: ?>
                                        <span style="color: #94a3b8; font-size: 14px; font-style: italic;">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-data">Belum ada data penghuni kos untuk ditagih.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>