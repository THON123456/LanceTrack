<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceOrder $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulance-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pemesan')->textInput() ?>

    <?= $form->field($model, 'id_ambulans')->textInput() ?>

    <?= $form->field($model, 'id_sopir')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Menunggu Konfirmasi' => 'Menunggu Konfirmasi', 'Diterima' => 'Diterima', 'Menunggu Ambulans Berangkat' => 'Menunggu Ambulans Berangkat', 'Menuju Lokasi Pasien' => 'Menuju Lokasi Pasien', 'Tiba di Lokasi Pasien' => 'Tiba di Lokasi Pasien', 'Menuju Rumah Sakit' => 'Menuju Rumah Sakit', 'Sampai di Rumah Sakit' => 'Sampai di Rumah Sakit', 'Selesai' => 'Selesai', 'Ditolak' => 'Ditolak', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
