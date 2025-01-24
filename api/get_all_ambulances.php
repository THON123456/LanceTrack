<?php
header("Content-Type: application/json");

// Koneksi ke database
include 'koneksi.php';

// Query untuk mengambil semua data dari tabel ambulances
$sql = "SELECT * FROM ambulance";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(["success" => false, "message" => "Query Error: " . $conn->error]);
    exit;
}

$ambulances = [];

// Mengambil data dari hasil query
while ($row = $result->fetch_assoc()) {
    $ambulances[] = [
        "id_ambulans" => $row['id_ambulance'],
        "nama" => $row['nama'],
        "tipe" => $row['tipe'],
        "plat" => $row['plat_nomor'],
        "lat" => $row['latitude'],
        "lon" => $row['longitude'],
        "status" => $row['status'],
        "gambar" => $row['foto'],
        
    ];
}

// Menutup koneksi database
$conn->close();

// Mengembalikan data dalam bentuk JSON
echo json_encode([
    "success" => true,
    "data" => $ambulances
]);
?>
