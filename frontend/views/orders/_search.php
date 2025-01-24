<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceorderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulance-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kode_order') ?>

    <?= $form->field($model, 'id_pemesanan') ?>

    <?= $form->field($model, 'id_ambulace') ?>

    <?= $form->field($model, 'id_sopir') ?>

    <?= $form->field($model, 'lat_tujuan') ?>

    <?php // echo $form->field($model, 'lon_tujuan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'waktu_order') ?>

    <?php // echo $form->field($model, 'kondisi') ?>

    <?php // echo $form->field($model, 'reviewed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
