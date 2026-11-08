<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan_modul6");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}