<?php
include "koneksi.php";

$tanggal_mulai = $_GET['tanggal_mulai'] ?? "";
$tanggal_akhir = $_GET['tanggal_akhir'] ?? "";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap_penjualan.xls");

if ($tanggal_mulai != "" && $tanggal_akhir != "") {
    $mulai = mysqli_real_escape_string($conn, $tanggal_mulai);
    $akhir = mysqli_real_escape_string($conn, $tanggal_akhir);

    $query = "SELECT DATE(waktu_transaksi) AS tanggal, SUM(total) AS total_harian FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$akhir' GROUP BY DATE(waktu_transaksi) ORDER BY tanggal ASC";

    $query_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$akhir'";
} else {
    $query = "SELECT DATE(waktu_transaksi) AS tanggal, SUM(total) AS total_harian FROM transaksi GROUP BY DATE(waktu_transaksi) ORDER BY tanggal ASC";

    $query_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah FROM transaksi";
}

$hasil = mysqli_query($conn, $query);
$hasil_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, $query_pelanggan));

echo "<table border='1'>";
echo "<tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>";

$no = 1;
$total_pendapatan = 0;
while ($row = mysqli_fetch_assoc($hasil)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['total_harian'] . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "</tr>";
    $total_pendapatan += $row['total_harian'];
}

echo "<tr><td colspan='2'>Jumlah Pelanggan</td><td>" . $hasil_pelanggan['jumlah'] . " Orang</td></tr>";
echo "<tr><td colspan='2'>Jumlah Pendapatan</td><td>" . $total_pendapatan . "</td></tr>";
echo "</table>";
?>