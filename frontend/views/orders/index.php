<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use frontend\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ambulance Orders';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => Orders::find()->with('ambulance', 'drivers'),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>
<div class="ambulance-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="ambulance-order-grid">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="ambulance-order-box">
                <table class="table table-bordered">
                    <tr>
                        <th>Kode Order</th>
                        <td><?= Html::encode($model->kode_order) ?></td>
                    </tr>
                    <tr>
                        <th>Pemesan</th>
                        <td><?= Html::encode($model->users ? $model->users->name : 'Data not available') ?></td>
                    </tr>
                    <tr>
                        <th>Ambulance</th>
                        <td><?= Html::encode($model->ambulance ? $model->ambulance->nama : 'Data not available') ?></td>
                    </tr>
                    <tr>
                        <th>Sopir</th>
                        <td><?= Html::encode($model->drivers ? $model->drivers->nama : 'Data not available') ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= Html::encode($model->status) ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Order</th>
                        <td><?= Html::encode($model->waktu_order) ?></td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td><?= Html::encode($model->kondisi) ?></td>
                    </tr>
                    <tr>
                        <th>Reviewed</th>
                        <td><?= Html::encode($model->reviewed ? 'Yes' : 'No') ?></td>
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
                            <?= Html::a('Lihat Review', ['view-reviews', 'id_ambulans' => $model->id_ambulans], ['class' => 'btn btn-primary']) ?>
                        <?php else: ?>
                            Data tidak tersedia
                        <?php endif; ?>
                    </p>
                </div>
                <div class="ambulance-order-actions">
                    <?= Html::a('View', ['view', 'kode_order' => $model->kode_order], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Update', ['update', 'kode_order' => $model->kode_order], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'kode_order' => $model->kode_order], [
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
.ambulance-order-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.ambulance-order-box {
    flex: 0 1 calc(33.333% - 30px);
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    background-color: #f9f9f9;
    text-align: left;
}

.table th, .table td {
    padding: 8px;
    text-align: left;
    border: none;
}

.table th {
    width: 40%;
    background-color: #f9f9f9;
    text-align: left;
}

.ambulance-order-actions {
    margin-top: 10px;
    text-align: center;
}

.ambulance-order-actions .btn {
    margin-right: 5px;
}
</style>
