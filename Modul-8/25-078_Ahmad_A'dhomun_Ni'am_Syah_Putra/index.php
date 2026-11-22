<?php
include 'koneksi.php';
include 'cek_login.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Sistem Penjualan</title>
</head>
<body>
<?php include 'navbar.php'; ?>
<div>
    <?php if (isset($_GET['akses']) && $_GET['akses'] == 'ditolak') { ?>
        <p><b>Anda tidak memiliki hak akses ke halaman tersebut.</b></p>
    <?php } ?>
    <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></h1>
    <p>Anda login sebagai <b><?php echo $_SESSION['level'] == 1 ? 'Owner' : 'Kasir'; ?></b>.</p>
</div>
</body>
</html>