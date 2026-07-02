<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil list kamar yang statusnya masih 'kosong'
$query_kamar = "SELECT id, nomor_kamar FROM rooms WHERE status = 'kosong'";
$result_kamar = mysqli_query($conn, $query_kamar);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penghuni - Jersey Kos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-bar"></div>
            <span>Jersey Kos</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php"><i class="fas fa-home"></i> &nbsp;Dashboard</a>
            <a href="kamar.php"><i class="fas fa-bed"></i> &nbsp;Kamar</a>
            <a href="tambah_penghuni.php" class="active"><i class="fas fa-users"></i> &nbsp;Penghuni</a>
            <a href="pembayaran.php"><i class="fas fa-money-bill-wave"></i> &nbsp;Pembayaran</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> &nbsp;Keluar</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><div class="title-bar"></div> Tambah Penghuni Baru</h1>
            <p class="subtitle">Masukkan data diri penghuni dan pilih kamar yang tersedia.</p>
        </div>

        <div class="form-container">
            <form action="proses_tambah.php" method="POST">
                
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap Penghuni</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Contoh: Brad Pitt" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">Nomor HP / WhatsApp</label>
                    <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="form-group">
                    <label for="room_id">Pilih Nomor Kamar</label>
                    <select id="room_id" name="room_id" required>
                        <option value="">-- Pilih Kamar yang Tersedia --</option>
                        <?php if(mysqli_num_rows($result_kamar) > 0): ?>
                            <?php while($kamar = mysqli_fetch_assoc($result_kamar)): ?>
                                <option value="<?php echo $kamar['id']; ?>">Kamar <?php echo htmlspecialchars($kamar['nomor_kamar']); ?></option>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <option value="" disabled>Semua kamar penuh / belum ada data kamar</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo date('Y-m-y'); ?>" required>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-submit">Simpan Penghuni</button>
                    <a href="index.php" class="btn-cancel">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>