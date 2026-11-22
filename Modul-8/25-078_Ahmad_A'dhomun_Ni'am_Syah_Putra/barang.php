<?php
include 'koneksi.php';
include 'cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: index.php?akses=ditolak");
    exit;
}

$pesan = "";
$edit = null;

if (isset($_POST['simpan'])) {
    $id    = (int) $_POST['id'];
    $kode  = trim($_POST['kode_barang']);
    $nama  = trim($_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    if ($kode === "" || $nama === "" || $harga < 0 || $stok < 0) {
        $pesan = "Kode, nama, harga, dan stok wajib diisi dengan benar.";
    } elseif ($id > 0) {
        $stmt = mysqli_prepare($koneksi, "UPDATE barang SET kode_barang = ?, nama_barang = ?, harga = ?, stok = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssiii", $kode, $nama, $harga, $stok, $id);
        mysqli_stmt_execute($stmt);
        $pesan = "Barang berhasil diubah.";
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO barang (kode_barang, nama_barang, harga, stok) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssii", $kode, $nama, $harga, $stok);
        mysqli_stmt_execute($stmt);
        $pesan = "Barang berhasil ditambahkan.";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    $cek = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM transaksi_detail WHERE barang_id = $id");
    $jumlah = mysqli_fetch_assoc($cek)['jumlah'];

    if ($jumlah > 0) {
        $pesan = "Barang tidak bisa dihapus karena masih digunakan pada $jumlah transaksi.";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        $pesan = "Barang berhasil dihapus.";
    }
}

if (isset($_GET['edit'])) {
    $eid = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM barang WHERE id = $eid"));
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="isi">
    <h2>Data Barang</h2>

    <?php if ($pesan != "") { ?>
        <p><b><?= htmlspecialchars($pesan) ?></b></p>
    <?php } ?>

    <form method="post" style="margin-bottom:20px">
        <input type="hidden" name="id" value="<?= $edit ? (int) $edit['id'] : 0 ?>">
        <input type="text" name="kode_barang" placeholder="Kode" value="<?= htmlspecialchars($edit['kode_barang'] ?? '') ?>">
        <input type="text" name="nama_barang" placeholder="Nama barang" value="<?= htmlspecialchars($edit['nama_barang'] ?? '') ?>">
        <input type="number" name="harga" placeholder="Harga" min="0" value="<?= htmlspecialchars($edit['harga'] ?? '') ?>">
        <input type="number" name="stok" placeholder="Stok" min="0" value="<?= htmlspecialchars($edit['stok'] ?? '') ?>">
        <button type="submit" name="simpan"><?= $edit ? 'Ubah' : 'Tambah' ?></button>
        <?php if ($edit) { ?><a href="barang.php">Batal</a><?php } ?>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($barang)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['kode_barang']) ?></td>
            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
            <td><?= $row['harga'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <a href="barang.php?edit=<?= $row['id'] ?>">Edit</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Yakin hapus barang ini?')">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" name="hapus">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>