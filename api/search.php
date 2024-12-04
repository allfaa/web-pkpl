<?php
header('Content-Type: application/json'); // Mengatur header untuk mengembalikan format JSON
$conn = new mysqli('localhost', 'root', '', 'toko'); // Membuat koneksi ke database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Menangani kesalahan koneksi
}

$query = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : ''; // Mengambil parameter 'q' dari URL dan membersihkan input

// Jika tidak ada parameter pencarian, tampilkan semua produk
if ($query) {
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$query%'"; // Pencarian berdasarkan nama barang
} else {
    $sql = "SELECT * FROM barang"; // Menampilkan semua produk jika tidak ada pencarian
}

$result = $conn->query($sql); // Menjalankan query

$data = []; // Array untuk menyimpan hasil pencarian
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { // Mengambil setiap baris hasil query
        $data[] = $row; // Menambahkan baris ke array data
    }
}

echo json_encode($data); // Mengembalikan hasil pencarian dalam format JSON
$conn->close(); // Menutup koneksi database
?>