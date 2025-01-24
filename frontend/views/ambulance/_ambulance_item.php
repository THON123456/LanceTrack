<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $model frontend\models\Ambulance */

?>
<div class="ambulance-box">
    <h3><?= Html::encode($model->nama) ?></h3>
    <p><strong>Tipe:</strong> <?= Html::encode($model->tipe) ?></p>
    <p><strong>Plat Nomor:</strong> <?= Html::encode($model->plat_nomor) ?></p>
    <p><strong>Rating Rata-Rata:</strong> <?= number_format($model->getAverageRating(), 2) ?></p>

    <div class="ambulance-actions">
        <?= Html::a('View', Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-info']) ?>
        <?= Html::a('Update', Url::to(['update', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', Url::to(['delete', 'id' => $model->id]), [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
