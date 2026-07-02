<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil semua data kamar dari database
$query_all_kamar = "SELECT * FROM rooms ORDER BY nomor_kamar ASC";
$result_all_kamar = mysqli_query($conn, $query_all_kamar);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kamar - Jersey Kos</title>
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
            <a href="index.php"><i class="fas fa-home"></i> &nbsp;Dashboard</a>
            <a href="kamar.php" class="active-menu"><i class="fas fa-bed"></i> &nbsp;Kamar</a>
            <a href="tambah_penghuni.php"><i class="fas fa-users"></i> &nbsp;Penghuni</a>
            <a href="pembayaran.php"><i class="fas fa-money-bill-wave"></i> &nbsp;Pembayaran</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> &nbsp;Keluar</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><div class="title-bar"></div> Manajemen Kamar Kos</h1>
            <p class="subtitle">Pantau status ketersediaan unit kamar atau tambahkan unit baru ke sistem.</p>
        </div>

        <div class="room-layout">
            <div class="room-grid">
                <?php if(mysqli_num_rows($result_all_kamar) > 0): ?>
                    <?php while($room = mysqli_fetch_assoc($result_all_kamar)): ?>
                        <div class="room-card">
                            <div class="room-number">Kamar <?php echo htmlspecialchars($room['nomor_kamar']); ?></div>
                            <div class="room-type"><?php echo htmlspecialchars($room['tipe_kamar']); ?></div>
                            <div class="room-price">Rp <?php echo number_format($room['harga_bulanan'], 0, ',', '.'); ?>/bln</div>
                            
                            <?php if($room['status'] == 'kosong'): ?>
                                <span class="status-badge kosong">Kosong</span>
                            <?php else: ?>
                                <span class="status-badge terisi">Terisi</span>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color: #94a3b8; grid-column: 1/-1; text-align: center; padding: 40px;">Belum ada data unit kamar kos yang didaftarkan.</p>
                <?php endif; ?>
            </div>

            <div class="form-container" style="width: 320px; flex-shrink: 0; padding: 24px;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #0f172a;"><i class="fas fa-plus-circle" style="color: #3c54c3;"></i> Tambah Kamar</h3>
                <form action="proses_kamar.php" method="POST">
                    
                    <div class="form-group">
                        <label for="nomor_kamar">Nomor Kamar</label>
                        <input type="text" id="nomor_kamar" name="nomor_kamar" placeholder="Contoh: 104" required>
                    </div>

                    <div class="form-group">
                        <label for="tipe_kamar">Tipe Kamar</label>
                        <select id="tipe_kamar" name="tipe_kamar" required>
                            <option value="Reguler">Reguler</option>
                            <option value="VIP">VIP</option>
                            <option value="VVIP">VVIP</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="harga_bulanan">Harga Bulanan (Rp)</label>
                        <input type="number" id="harga_bulanan" name="harga_bulanan" placeholder="Contoh: 1500000" required>
                    </div>

                    <button type="submit" class="btn-submit" style="width: 100%; margin-top: 10px;">Simpan Kamar</button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>