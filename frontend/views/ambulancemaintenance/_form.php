<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Ambulance; // Pastikan Anda mengimpor model Ambulance

/** @var yii\web\View $this */
/** @var app\models\AmbulanceMaintenance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulance-maintenance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    // Ambil semua ambulance yang statusnya "maintenance"
    $ambulances = Ambulance::find()->where(['status' => '1'])->all();
    
    // Siapkan data untuk dropdown
    $ambulanceList = ArrayHelper::map($ambulances, 'id_ambulance', 'nama');
    ?>

    <?= $form->field( $model, 'id_ambulance')->dropDownList($ambulanceList, ['prompt' => 'Pilih Ambulance']) ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biaya')->textInput() ?>

    <?= $form->field($model, 'waktu')->input('datetime-local') ?> <!-- Input datetime -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
