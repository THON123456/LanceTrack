<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AmbulanceUlasan */

?>
<div class="card">
    <div class="card-header">
        <h4><?= Html::encode($model->review) ?></h4>
    </div>
    <div class="card-body">
        <p><strong>Rating:</strong> <?= Html::encode($model->rating) ?></p>
        <p><strong>User ID:</strong> <?= Html::encode($model->user_id) ?></p>
    </div>
    <div class="card-footer">
        <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
