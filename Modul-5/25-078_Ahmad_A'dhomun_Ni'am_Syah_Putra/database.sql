CREATE DATABASE IF NOT EXISTS penjualan_modul5;
USE penjualan_modul5;


CREATE TABLE IF NOT EXISTS pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL
);


CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL
);


CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(12,0) NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATETIME NOT NULL,
    keterangan TEXT,
    total DECIMAL(12,0) NOT NULL,
    pelanggan_id INT NOT NULL,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga DECIMAL(12,0) NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level VARCHAR(50) NOT NULL
);


CREATE TABLE IF NOT EXISTS pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total DECIMAL(12,0) NOT NULL,
    metode ENUM('Tunai', 'Transfer', 'QRIS') NOT NULL,
    transaksi_id INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
);


INSERT INTO supplier (nama, telp, alamat) VALUES
('PT. Mega Nusa Perkasa', '081199887766', 'Mojokerto'),
('CV. Citra Buana Mandiri', '081288776655', 'Surabaya'),
('UD. Karya Sejahtera', '081377665544', 'Lamongan'),
('PT. Mitra Teknik Utama', '081466554433', 'Sidoarjo'),
('CV. Bintang Samudera', '081555443322', 'Bangkalan'),
('UD. Sumber Berkat', '081644332211', 'Bojonegoro'),
('PT. Global Mandiri Sukses', '081733221100', 'Tuban'),
('CV. Anugerah Abadi Jaya', '081822110099', 'Probolinggo'),
('UD. Pangan Lestari', '081911009988', 'Gresik'),
('PT. Techno Nusantara', '081000998877', 'Ngawi');


INSERT INTO pelanggan (nama, jenis_kelamin, telp, alamat) VALUES
('Hendra Wijaya', 'L', '087812345001', 'Bandung'),
('Putri Ananda', 'P', '087812345002', 'Jakarta Pusat'),
('Reza Pahlevi', 'L', '087812345003', 'Surabaya'),
('Nurul Hidayah', 'P', '087812345004', 'Malang'),
('Dimas Anggara', 'L', '087812345005', 'Semarang'),
('Rika Aprilia', 'P', '087812345006', 'Yogyakarta'),
('Bayu Setiawan', 'L', '087812345007', 'Surakarta'),
('Tika Puspita', 'P', '087812345008', 'Denpasar'),
('Agung Prasetyo', 'L', '087812345009', 'Makassar'),
('Mega Mustika', 'P', '087812345010', 'Palembang');


INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('ELK-501', 'Smart TV 32 Inch', 2400000, 10, 4),
('ELK-502', 'Blender Digital 3-in-1', 450000, 15, 4),
('ELK-503', 'Rice Cooker 2 Liter', 320000, 25, 4),
('OFC-201', 'Meja Direktur Minimalis', 1750000, 5, 1),
('OFC-202', 'Kursi Jaring Eksekutif', 850000, 12, 1),
('SRO-901', 'Teh Hitam Celup (Box)', 12000, 100, 9),
('SRO-902', 'Kopi Robusta 250g', 25000, 50, 9),
('SRO-903', 'Susu Kental Manis 500g', 18000, 80, 9),
('ACC-301', 'Powerbank 10000mAh', 210000, 30, 10),
('ACC-302', 'Charger Fast Charging 20W', 125000, 40, 10);


INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-11-02 09:00:00', 'Pembelian elektronik rumah tangga', 2850000, 1),
('2026-11-02 10:15:00', 'Belanja kebutuhan dapur dan beras', 55000, 2),
('2026-11-02 11:30:00', 'Pengadaan perabot ruang kerja', 2600000, 3),
('2026-11-02 13:00:00', 'Beli aksesoris gadget', 335000, 4),
('2026-11-02 14:20:00', 'Pembelian rice cooker baru', 320000, 5),
('2026-11-02 15:10:00', 'Belanja minuman dan kopi', 37000, 6),
('2026-11-02 16:00:00', 'Beli kursi eksekutif', 850000, 7),
('2026-11-02 16:45:00', 'Belanja kebutuhan warung', 43000, 8),
('2026-11-02 17:30:00', 'Beli powerbank & charger', 335000, 9),
('2026-11-02 18:15:00', 'Pembelian blender', 450000, 10);


INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 2400000, 1),
(1, 3, 320000, 1),
(2, 6, 12000, 1),
(2, 8, 18000, 2),
(3, 4, 1750000, 1),
(3, 5, 850000, 1),
(4, 9, 210000, 1),
(4, 10, 125000, 1),
(5, 3, 320000, 1),
(6, 7, 25000, 1);


INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('operator01', 'pass999', 'Fauzan Operator', 'Medan', '081399887711', 'Admin'),
('kasir_barat', 'pass999', 'Siska Kasir', 'Padang', '081399887722', 'Kasir'),
('gudang_utama', 'pass999', 'Budi Gudang', 'Pekanbaru', '081399887733', 'Staff Gudang'),
('kasir_selatan', 'pass999', 'Lina Kasir', 'Palembang', '081399887744', 'Kasir'),
('supervisor', 'pass999', 'Dedi Supervisor', 'Bandar Lampung', '081399887755', 'Manager'),
('finance_mgr', 'pass999', 'Sri Finance', 'Jakarta', '081399887766', 'Owner'),
('kasir_timur', 'pass999', 'Wati Kasir', 'Bandung', '081399887777', 'Kasir'),
('gudang_cabang', 'pass999', 'Eko Gudang', 'Semarang', '081399887788', 'Staff Gudang'),
('admin_web', 'pass999', 'Rian Admin', 'Surabaya', '081399887799', 'Admin'),
('kasir_utama', 'pass999', 'Nita Kasir', 'Malang', '081399887700', 'Kasir');


INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-11-02 09:05:00', 2850000, 'Transfer', 1),
('2026-11-02 10:20:00', 55000, 'Tunai', 2),
('2026-11-02 11:35:00', 2600000, 'QRIS', 3),
('2026-11-02 13:05:00', 335000, 'Transfer', 4),
('2026-11-02 14:25:00', 320000, 'Tunai', 5),
('2026-11-02 15:15:00', 37000, 'Tunai', 6),
('2026-11-02 16:05:00', 850000, 'QRIS', 7),
('2026-11-02 16:50:00', 43000, 'Tunai', 8),
('2026-11-02 17:35:00', 335000, 'Transfer', 9),
('2026-11-02 18:20:00', 450000, 'Tunai', 10);