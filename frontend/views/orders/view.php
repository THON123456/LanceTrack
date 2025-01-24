<?php

use frontend\models\Reviews; // Model untuk ulasan
use frontend\models\Orders; // Model untuk pesanan
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */

$this->title = $model->kode_order;
$this->params['breadcrumbs'][] = ['label' => 'Ambulance Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode_order',
            'id_pemesan',
            'id_ambulans',
            'status',
            'alasan',
            'waktu_order',
            'kondisi',
            'reviewed',
        ],
    ]) ?>

    <h2>Reviews</h2>
    <?php if (!empty($model->reviews)): ?>
        <?php foreach ($model->reviews as $review): ?>
            <div>
                <h3>Review for Ambulance</h3>
                <p>Rating: <?= Html::encode($review->rating_ambulans) ?></p>
                <p>Review: <?= Html::encode($review->review_ambulans) ?></p>

                <h3>Review for Driver</h3>
                <p>Rating: <?= Html::encode($review->rating_sopir) ?></p>
                <p>Review: <?= Html::encode($review->review_sopir) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews available.</p>
    <?php endif; ?>

    <h2>Daftar Pesanan yang Menunggu Konfirmasi</h2>
    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => Orders::find()->where(['status' => 'Menunggu Konfirmasi'])->with('ambulance'),
        'pagination' => [
            'pageSize' => 5, // Menampilkan 5 pesanan terbaru
        ],
    ]);
    ?>

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
                <?php foreach ($dataProvider->getModels() as $order): ?>
                    <tr>
                        <td><?= Html::encode($order->kode_order) ?></td>
                        <td><?= Html::encode($order->ambulance ? $order->ambulance->tipe : 'Data not available') ?></td>
                        <td><?= Html::encode($order->pegawai ? $order->pegawai->nama : 'Data not available') ?></td>
                        <td><?= Html::encode($order->status) ?></td>
                        <td><?= Html::encode($order->alasan) ?></td>
                        <td><?= Html::encode($order->waktu_order) ?></td>
                        <td><?= Html::encode($order->kondisi) ?></td>
                        <td><?= Html::encode($order->reviewed ? 'Yes' : 'No') ?></td>
                        <td>
                            <?= Html::a('Terima', ['site/accept', 'kode_order' => $order->kode_order], [
                                'class' => 'btn btn-success',
                                'data-id' => $order->kode_order,
                                'data-url' => Url::to(['site/accept']),
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure you want to accept this order?'
                            ]) ?>
                            <?= Html::a('Tolak', ['site/reject', 'kode_order' => $order->kode_order], [
                                'class' => 'btn btn-danger',
                                'data-id' => $order->kode_order,
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
