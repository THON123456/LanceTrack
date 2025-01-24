<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ambulanceshift $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulanceshift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_shift')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'waktu_shift_terakhir')->textInput() ?>

    <?= $form->field($model, 'biodata_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
