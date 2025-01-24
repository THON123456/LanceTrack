<?php
header("Content-Type: application/json");

// Koneksi ke database
include 'koneksi.php';

// Ambil data dari permintaan POST
$data = json_decode(file_get_contents("php://input"));

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Invalid JSON"]);
    exit;
}

$id = $conn->real_escape_string($data->id_ambulans);

if (!$id) {
    echo json_encode(["success" => false, "message" => "Missing id"]);
    exit;
}

// Query untuk mendapatkan detail pemesanan dan nama sopir dengan status selain "selesai"
$sql = "
SELECT *
FROM ambulance
WHERE id_ambulance = '$id'
";

$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(["success" => false, "message" => "Query Error: " . $conn->error]);
    exit;
}

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();

    $lat = $order['latitude'];
    $lon = $order['longitude'];

    // Panggil Nominatim API untuk mendapatkan nama alamat
    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MyApp/1.0 (myemail@example.com)');
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        $locationData = json_decode($response, true);
        $address = $locationData['display_name'] ?? 'Address not found';
    } else {
        $address = 'Address not found';
    }

    echo json_encode([
        "success" => true,
        "data" => [
            "id" => $order['id_ambulance'],
            "nama" => $order['nama'],
            "tipe" => $order['tipe'],
            "plat" => $order['plat_nomor'],
            "lat" => $order['latitude'],
            "lon" => $order['longitude'],
            "address" => $address,
            "status" => $order['status'],
            "gambar" => $order['foto'],
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Order tidak ditemukan"]);
}

$conn->close();
?>
