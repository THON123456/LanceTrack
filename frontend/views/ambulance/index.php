<?php

use frontend\models\Ambulance;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AmbulanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this View */
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
$this->title = 'Ambulances';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => Ambulance::find(),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>
<div class="ambulance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ambulance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="ambulance-grid">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="ambulance-box">
                <?php if ($model->foto): ?>
                    <img src="<?= Yii::getAlias('@web') . '/upload/' . Html::encode($model->foto) ?>" alt="Foto Ambulance">
                <?php endif; ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td><?= Html::encode($model->nama) ?></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td><?= Html::encode($model->tipe) ?></td>
                    </tr>
                    <tr>
                        <th>Plate Number</th>
                        <td><?= Html::encode($model->plat_nomor) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= Html::encode($model->status == 0 ? 'Ready' : 'Maintenance') ?></td>
                    </tr>
                </table>

                <!-- Menampilkan Average Rating dan Review di luar tabel -->
                <div class="ambulance-rating-review">
                    <p>
                        <strong>Average Rating:</strong> 
                        <?= number_format($model->getAverageRating(), 2) ?>
                        <?php
                        $rating = $model->getAverageRating();
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<i class="fa' . ($i <= $rating ? 's' : 'r') . ' fa-star"></i>';
                        }
                        ?>
                    </p>
                    <p>
                        <strong>Review:</strong>
                        <?php if ($model->getReviews()->count() > 0): ?>
                            <?= Html::a('Lihat Review', ['view-reviews', 'id_ambulance' => $model->id_ambulance], ['class' => 'btn btn-primary']) ?>
                        <?php else: ?>
                            Data tidak tersedia
                        <?php endif; ?>
                    </p>
                </div>

                <div class="ambulance-actions btn-group">
                    <?= Html::a('View', ['view', 'id_ambulance' => $model->id_ambulance], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Update', ['update', 'id_ambulance' => $model->id_ambulance], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id_ambulance' => $model->id_ambulance], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post',
                    ]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<style>
.ambulance-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.ambulance-box {
    flex: 0 1 30%;
    margin: 15px 0;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    background-color: #f9f9f9;
    text-align: left;
}

.ambulance-box img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

.table th, .table td {
    padding: 8px;
    text-align: left;
    border: none;
}

.table th {
    width: 40%;
    background-color: #f9f9f9;
}

.ambulance-rating-review {
    margin-top: 15px;
    font-size: 14px;
}

.ambulance-rating-review .fa-star {
    color: gold; /* Mengubah warna bintang menjadi kuning */
    margin-left: 5px;
}

.ambulance-actions {
    margin-top: 10px;
    text-align: center;
}

.ambulance-actions .btn-group .btn {
    margin-right: 5px;
}
</style>

