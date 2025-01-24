<?php
/* @var $this yii\web\View */

$this->title = 'Update Location';
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY', ['position' => \yii\web\View::POS_HEAD]);
?>

<script>
navigator.geolocation.watchPosition(function(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?= \yii\helpers\Url::to(['ambulance-location/update']) ?>", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    var data = "latitude=" + latitude + "&longitude=" + longitude;
    xhr.send(data);
}, function(error) {
    console.error(error);
}, {
    enableHighAccuracy: true
});
</script>
