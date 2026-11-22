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
    $id       = (int) $_POST['id'];
    $username = trim($_POST['username']);
    $nama     = trim($_POST['nama']);
    $alamat   = trim($_POST['alamat']);
    $hp       = trim($_POST['hp']);
    $level    = (int) $_POST['level'];
    $password = $_POST['password'];

    if ($id == $_SESSION['user_id']) {
        $level = $_SESSION['level'];
    }

    $stmt = mysqli_prepare($koneksi, "SELECT id FROM user WHERE username = ? AND id <> ?");
    mysqli_stmt_bind_param($stmt, "si", $username, $id);
    mysqli_stmt_execute($stmt);
    $dobel = mysqli_num_rows(mysqli_stmt_get_result($stmt));

    if ($username === "" || $nama === "" || !in_array($level, [1, 2])) {
        $pesan = "Username, nama, dan level (1 atau 2) wajib diisi dengan benar.";
    } elseif ($id == 0 && $password === "") {
        $pesan = "Password wajib diisi untuk user baru.";
    } elseif ($dobel > 0) {
        $pesan = "Username sudah dipakai.";
    } elseif ($id > 0) {
        if ($password !== "") {
            $stmt = mysqli_prepare($koneksi, "UPDATE user SET username = ?, password = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssssii", $username, $password, $nama, $alamat, $hp, $level, $id);
        } else {
            $stmt = mysqli_prepare($koneksi, "UPDATE user SET username = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
        }
        mysqli_stmt_execute($stmt);
        if ($id == $_SESSION['user_id']) {
            $_SESSION['nama'] = $nama;
            $_SESSION['username'] = $username;
        }
        $pesan = "User berhasil diubah.";
    } else {
        $stmt = mysqli_prepare($koneksi, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $password, $nama, $alamat, $hp, $level);
        mysqli_stmt_execute($stmt);
        $pesan = "User berhasil ditambahkan.";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];
    if ($id == $_SESSION['user_id']) {
        $pesan = "Akun yang sedang dipakai login tidak bisa dihapus.";
    } else {
        mysqli_query($koneksi, "DELETE FROM user WHERE id = $id");
        $pesan = "User berhasil dihapus.";
    }
}

if (isset($_GET['edit'])) {
    $eid = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id = $eid"));
}

$data = mysqli_query($koneksi, "SELECT id, username, nama, alamat, hp, level FROM user ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="isi">
    <h2>Data User</h2>

    <?php if ($pesan != "") { ?>
        <p><b><?= htmlspecialchars($pesan) ?></b></p>
    <?php } ?>

    <form method="post" style="margin-bottom:20px">
        <input type="hidden" name="id" value="<?= $edit ? (int) $edit['id'] : 0 ?>">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($edit['username'] ?? '') ?>">
        <input type="password" name="password" placeholder="<?= $edit ? 'Password (kosongkan jika tidak diubah)' : 'Password' ?>" autocomplete="new-password">
        <input type="text" name="nama" placeholder="Nama" value="<?= htmlspecialchars($edit['nama'] ?? '') ?>">
        <input type="text" name="alamat" placeholder="Alamat" value="<?= htmlspecialchars($edit['alamat'] ?? '') ?>">
        <input type="text" name="hp" placeholder="No. HP" value="<?= htmlspecialchars($edit['hp'] ?? '') ?>">
        <select name="level">
            <option value="1" <?= ($edit['level'] ?? 2) == 1 ? 'selected' : '' ?>>1 - Owner</option>
            <option value="2" <?= ($edit['level'] ?? 2) == 2 ? 'selected' : '' ?>>2 - Kasir</option>
        </select>
        <button type="submit" name="simpan"><?= $edit ? 'Ubah' : 'Tambah' ?></button>
        <?php if ($edit) { ?><a href="user.php">Batal</a><?php } ?>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr><th>ID</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Aksi</th></tr>
        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['alamat'] ?? '') ?></td>
            <td><?= htmlspecialchars($row['hp'] ?? '') ?></td>
            <td><?php
                if ($row['level'] == 1) echo 'level 1 - Owner';
                elseif ($row['level'] == 2) echo 'level 2 - Kasir';
                else echo 'Level ' . $row['level'];
            ?></td>
            <td>
                <a href="user.php?edit=<?= $row['id'] ?>">Edit</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Yakin hapus user ini?')">
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