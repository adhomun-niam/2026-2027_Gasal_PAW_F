<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$pesan = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        $pesan = "Username dan password wajib diisi.";
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password, nama, level FROM user WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($row && ($row['level'] == 1 || $row['level'] == 2)) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama']     = $row['nama'];
            $_SESSION['level']    = (int) $row['level'];

            header("Location: index.php");
            exit;
        } else {
            $pesan = "Login Gagal! Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Penjualan</title>
</head>
<body>
    <h2>Login Sistem Penjualan</h2>
    <?php if ($pesan != "") echo "<p><strong>" . htmlspecialchars($pesan) . "</strong></p>"; ?>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Masuk</button>
    </form>
</body>
</html>