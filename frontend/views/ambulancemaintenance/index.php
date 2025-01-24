<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AmbulanceMaintenanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ambulance Maintenance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-maintenance-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ambulance Maintenance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ambulance.nama',
            'ambulance.plat_nomor',
            'keterangan',
            'biaya',
            'waktu',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
