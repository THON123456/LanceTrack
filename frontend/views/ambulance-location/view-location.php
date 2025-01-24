<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Ambulance; // Sesuaikan dengan namespace dan nama model yang sesuai

$this->title = 'Ambulance Locations';
$this->params['breadcrumbs'][] = $this->title;

// URL untuk akses action get-ambulances di controller AmbulanceLocation
$getAmbulancesUrl = Url::to(['ambulance-location/get-ambulances']);

// Menambahkan file CSS dan JavaScript yang diperlukan
$this->registerCssFile('https://unpkg.com/leaflet/dist/leaflet.css');
$this->registerJsFile('https://unpkg.com/leaflet/dist/leaflet.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>
<div class="ambulance-location">
    <h1><?= Html::encode($this->title) ?></h1>
    <div id="map" style="height: 600px; margin-bottom: 20px;"></div>
    
    <div id="ambulance-list" style="margin-top: 20px;">
        <h2>Ambulance List</h2>
        <img src="https://img.icons8.com/color/96/ambulance.png" alt="Ambulance Image" style="display: block; margin: 0 auto 20px;">
        <div id="ambulance-data">
            <!-- Data ambulance akan diisi di sini -->
        </div>
    </div>
</div>

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
            fetch('<?= \yii\helpers\Url::to(['ambulance-location/get-ambulances']) ?>')
            .then(response => response.json())
            .then(data => {
                    // Hapus semua marker yang ada sebelumnya
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });

                    // Hapus semua data di daftar ambulance
                    var ambulanceDataList = document.getElementById('ambulance-data');
                    ambulanceDataList.innerHTML = '';

                    // Tambahkan marker baru dari data yang diperoleh
                    data.forEach(function(ambulance) {
                        L.marker([ambulance.latitude, ambulance.longitude], { icon: customIcon }).addTo(map)
                            .bindPopup('<b>' + ambulance.nama + '</b><br>' + ambulance.plat_nomor);

                        // Tambahkan data ke dalam daftar ambulance
                        var listItem = document.createElement('div');
                        listItem.style.padding = '10px';
                        listItem.style.marginBottom = '10px';
                        listItem.style.border = '1px solid #ddd';
                        listItem.style.borderRadius = '5px';
                        listItem.style.backgroundColor = '#f8f9fa';
                        listItem.innerHTML = `
                            <b>Nama:</b> ${ambulance.nama}<br>
                            <b>Plat Nomor:</b> ${ambulance.plat_nomor}<br>
                            <b>Latitude:</b> ${ambulance.latitude}<br>
                            <b>Longitude:</b> ${ambulance.longitude}<br>
                        `;
                        ambulanceDataList.appendChild(listItem);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Panggil fungsi updateMarkers setiap 10 detik (10000 ms)
        setInterval(updateMarkers, 10000);

        // Panggil updateMarkers pertama kali saat halaman dimuat
        updateMarkers();
    });
</script>
