<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use frontend\models\Orders;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main_after_login'; // Set layout baru

// DataProvider untuk mengambil pesanan yang menunggu konfirmasi
$dataProvider = new ActiveDataProvider([
    'query' => Orders::find()->where(['status' => 'Menunggu Konfirmasi'])->with('ambulance'),
    'pagination' => [
        'pageSize' => 5, // Menampilkan 5 pesanan terbaru
    ],
]);

?>
 <!-- Baris Statistik Pertama -->
   <div class="row">
    <div class="col-lg-4">
        <div class="stat-boxes text-white">
            <div class="content-box shadowed-box text-center bg-success">
                <h2><i class="fas fa-users text-white"></i> Jumlah Pesanan</h2>
                <p class="display-4 text-white"><?= Html::encode($jumlahPemesan) ?></p>
            </div>
            <!-- Box View Detail -->
            <div class="view-detail-box">
                <span class="view-detail-text">View Detail</span>
                <a href="<?= Url::to(['orders/index']) ?>" class="view-detail-arrow">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="stat-boxes text-white">
            <div class="content-box shadowed-box text-center bg-primary">
                <h2><i class="fas fa-tools text-white"></i> Ambulance Ready</h2>
                <p class="display-4 text-white"><?= Html::encode($jumlahAmbulanceReady) ?></p>
            </div>
            <!-- Box View Detail -->
            <div class="view-detail-box">
                <span class="view-detail-text">View Detail</span>
                <a href="<?= Url::to(['ambulance/index']) ?>" class="view-detail-arrow">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="stat-boxes text-white">
            <div class="content-box shadowed-box text-center bg-danger">
                <h2><i class="fas fa-wrench text-white"></i> Ambulance Rusak</h2>
                <p class="display-4 text-white"><?= Html::encode($jumlahAmbulanceRusak) ?></p>
            </div>
            <!-- Box View Detail -->
            <div class="view-detail-box">
                <span class="view-detail-text">View Detail</span>
                <a href="<?= Url::to(['ambulancemaintenance/index']) ?>" class="view-detail-arrow">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="site-dashboard">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Daftar Pesanan</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Order</th> 
                                <th>Id Pemesanan</th> 
                                <th>Id Ambulance</th> 
                                <th>Id Sopir</th>
                                <th>Status</th> 
                                <th>Alasan</th> 
                                <th>Waktu Order</th> 
                                <th>Kondisi</th> 
                                <th>Reviewed</th> 
                                <th>Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataProvider->getModels() as $model): ?>
                                <tr>
                                    <td><?= Html::encode($model->kode_order) ?></td>
                                    <td><?= Html::encode($model->ambulanceBooking ? $model->ambulanceBooking->nama : 'Data not available') ?></td>
                                    <td><?= Html::encode($model->ambulance ? $model->ambulance->tipe : 'Data not available') ?></td>
                                    <td><?= Html::encode($model->pegawai ? $model->pegawai->nama : 'Data not available') ?></td>
                                    <td><?= Html::encode($model->status) ?></td>
                                    <td><?= Html::encode($model->alasan) ?></td>
                                    <td><?= Html::encode($model->waktu_order) ?></td>
                                    <td><?= Html::encode($model->kondisi) ?></td>
                                    <td><?= Html::encode($model->reviewed ? 'Yes' : 'No') ?></td>
                                    <td>
                                        <?= Html::a('Terima', ['orders/accept', 'kode_order' => $model->kode_order], [
                                            'class' => 'btn btn-success',
                                            'data-id' => $model->kode_order,
                                            'data-url' => Url::to(['orders/accept']),
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure you want to accept this order?'
                                        ]) ?>
                                        <?= Html::a('Tolak', ['site/reject', 'kode_order' => $model->kode_order], [
                                            'class' => 'btn btn-danger',
                                            'data-id' => $model->kode_order,
                                            'data-url' => Url::to(['site/reject']),
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure you want to reject this order?'
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Peta -->
        <div class="map-container">
            <div id="map" style="height: 600px;"></div>
        </div>
    </div>
</div>
<style>
.site-dashboard {
    padding: 20px;
}


.stat-boxes {
    position: relative; /* Menentukan posisi relative untuk box statistik */
    margin-bottom: 0; /* Menghapus margin bawah pada container box statistik */
}

.content-box {
    padding: 20px; /* Padding inside the box */
    border-radius: 8px; /* Rounded corners */
}

.view-detail-box {
    position: absolute; /* Mengatur posisi absolute untuk box view detail */
    bottom: 0; /* Menempelkan box view detail di bagian bawah box statistik */
    left: 0;
    right: 0;
    padding: 10px; /* Padding inside the box */
    border-radius: 0 0 8px 8px; /* Rounded corners hanya pada bagian bawah */
    background-color: #f8f9fa; /* Warna abu-abu muda untuk background box view detail */
    color: #343a40; /* Warna teks untuk box view detail */
    border-top: 1px solid #ced4da; /* Border atas box view detail */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
}

.view-detail-arrow {
    position: absolute; /* Mengatur posisi absolute untuk arrow */
    right: 10px; /* Jarak dari tepi kanan */
    top: 50%; /* Menempatkan arrow di tengah vertikal */
    transform: translateY(-50%); /* Menyelaraskan posisi arrow secara vertikal */
    background-color: #343a40; /* Warna latar belakang bulat untuk arrow */
    color: #fff; /* Warna teks arrow */
    padding: 5px; /* Padding untuk ukuran bulat */
    border-radius: 50%; /* Membuat bentuk bulat */
    text-decoration: none; /* Menghapus garis bawah dari link */
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-detail-text {
    font-size: 1rem; /* Ukuran font untuk view detail */
}

.view-detail-arrow {
    color: #ffffff; /* Warna teks untuk arrow */
    text-decoration: none; /* Hapus garis bawah dari link */
}

.view-detail-arrow i {
    font-size: 1.5rem; /* Ukuran icon arrow */
}

.shadowed-box {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
    border-radius: 10px; /* Rounded corners */
    margin-bottom: 20px; /* Margin at the bottom */
}

#map {
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow */
}

.content-box {
    background-color: #ffffff; /* White background color */
    padding: 20px; /* Padding inside the box */
    margin-top: 20px; /* Margin at the top */
}

.display-4 {
    font-size: 2.5rem; /* Display size for numbers */
}

.text-center {
    text-align: center; /* Center text alignment */
}

.stat-boxes {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.content-box.flex-fill {
    flex: 1;
}

.ambulance-order-grid {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.table th, .table td {
    padding: 8px;
    text-align: center; /* Mengatur teks menjadi rata tengah */
}

.table th {
    background-color: #f9f9f9;
}

.ambulance-order-actions {
    margin-top: 10px;
    text-align: center;
    width: 100%;
}

.ambulance-order-actions .btn {
    margin-right: 5px;
}

.map-container {
    margin-top: 20px;
}
</style>

<!-- Jangan lupa untuk memuat Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Menambahkan Leaflet CSS dan JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([-6.956365995358789, 107.61254720955608], 13); // Koordinat awal Bandung

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var customIcon = L.icon({
            iconUrl: 'https://img.icons8.com/color/48/ambulance.png',
            iconSize: [38, 38],
            iconAnchor: [19, 38],
            popupAnchor: [0, -38]
        });

        // Function untuk memperbarui posisi marker ambulance dari data yang diambil
        function updateMarkers() {
            fetch('<?= Url::to(['ambulance-location/get-ambulances']) ?>')
                .then(response => response.json())
                .then(data => {
                    // Hapus semua marker yang ada sebelumnya
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });

                    // Tambahkan marker baru dari data yang diperoleh
                    data.forEach(function(ambulance) {
                        L.marker([ambulance.latitude, ambulance.longitude], { icon: customIcon })
                            .addTo(map)
                            .bindPopup(`<b>${ambulance.nama}</b><br>Nomor: ${ambulance.plat_nomor}`);
                    });
                });
        }

        // Panggil updateMarkers setiap 10 detik
        setInterval(updateMarkers, 10000);
    });
</script>
