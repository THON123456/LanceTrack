<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pegawaiProvider yii\data\ActiveDataProvider */
/* @var $staffToday array */
/* @var $shiftStartTime int */
/* @var $shiftEndTime int */

$this->title = 'Ambulance Shifts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulanceshift-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ambulance Shift', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <h2>Shift Schedule</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nama_shift',
            'waktu_shift_terakhir',
            [
                'attribute' => 'pegawai_id',
                'value' => 'pegawai.nama',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <h2>Data Pegawai</h2>
    <?= GridView::widget([
        'dataProvider' => $pegawaiProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_pegawai',
            'nama',
            'nip',
            'alamat',
            [
                'attribute' => 'id_jabatan',
                'value' => 'jabatan.jabatan',
            ],
        ],
    ]); ?>

    <h2>Staff on Duty Today</h2>
    <p>Shift Time: <?= date('Y-m-d H:i:s', $shiftStartTime) ?> - <?= date('Y-m-d H:i:s', $shiftEndTime) ?></p>
    <ul>
        <li><strong>Sopir:</strong>
            <?php if ($staffToday['sopir']): ?>
                <ul>
                    <li><?= Html::encode($staffToday['sopir']->nama) ?> (<?= Html::encode($staffToday['sopir']->alamat) ?>)</li>
                </ul>
            <?php else: ?>
                <p>No Sopir Available</p>
            <?php endif; ?>
        </li>
        <li><strong>Dokter:</strong>
            <?php if ($staffToday['dokter']): ?>
                <ul>
                    <li><?= Html::encode($staffToday['dokter']->nama) ?> (<?= Html::encode($staffToday['dokter']->alamat) ?>)</li>
                </ul>
            <?php else: ?>
                <p>No Dokter Available</p>
            <?php endif; ?>
        </li>
        <li><strong>Perawat:</strong>
            <?php if ($staffToday['perawat']): ?>
                <ul>
                    <?php foreach ($staffToday['perawat'] as $perawat): ?>
                        <li><?= Html::encode($perawat->nama) ?> (<?= Html::encode($perawat->alamat) ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No Perawat Available</p>
            <?php endif; ?>
        </li>
    </ul>

</div>
