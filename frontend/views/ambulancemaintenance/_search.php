<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AmbulancemaintenanceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulance-maintenance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_ambulance') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'biaya') ?>

    <?= $form->field($model, 'waktu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
