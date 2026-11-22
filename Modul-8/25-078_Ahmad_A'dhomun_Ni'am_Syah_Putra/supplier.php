<?php
include 'koneksi.php';
include 'cek_login.php';

// Hanya owner (level 1)
if ($_SESSION['level'] != 1) {
    header("Location: index.php?akses=ditolak");
    exit;
}

$pesan = "";
$edit = null;

if (isset($_POST['simpan'])) {
    $id      = (int) $_POST['id'];
    $nama    = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat  = trim($_POST['alamat']);

    if ($nama === "") {
        $pesan = "Nama wajib diisi.";
    } elseif ($id > 0) {
        $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);
        mysqli_stmt_execute($stmt);
        $pesan = "Data berhasil diubah.";
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
        mysqli_stmt_execute($stmt);
        $pesan = "Data berhasil ditambahkan.";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];
    try {
        mysqli_query($koneksi, "DELETE FROM supplier WHERE id = $id");
        $pesan = "Data berhasil dihapus.";
    } catch (mysqli_sql_exception $ex) {
        $pesan = "Data tidak bisa dihapus karena masih digunakan di data lain.";
    }
}

if (isset($_GET['edit'])) {
    $eid = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM supplier WHERE id = $eid"));
}

$data = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="isi">
    <h2>Data Supplier</h2>

    <?php if ($pesan != "") { ?>
        <p><b><?= htmlspecialchars($pesan) ?></b></p>
    <?php } ?>

    <form method="post" style="margin-bottom:20px">
        <input type="hidden" name="id" value="<?= $edit ? (int) $edit['id'] : 0 ?>">
        <input type="text" name="nama" placeholder="Nama" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>">
        <input type="text" name="telp" placeholder="Telepon" value="<?= htmlspecialchars($edit['telp'] ?? '') ?>">
        <input type="text" name="alamat" placeholder="Alamat" value="<?= htmlspecialchars($edit['alamat'] ?? '') ?>">
        <button type="submit" name="simpan"><?= $edit ? 'Ubah' : 'Tambah' ?></button>
        <?php if ($edit) { ?><a href="supplier.php">Batal</a><?php } ?>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>ID</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr>
        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['telp'] ?? '') ?></td>
            <td><?= htmlspecialchars($row['alamat'] ?? '') ?></td>
            <td>
                <a href="supplier.php?edit=<?= $row['id'] ?>">Edit</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
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