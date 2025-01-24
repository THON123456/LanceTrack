<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReviewsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reviews-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_order') ?>

    <?= $form->field($model, 'id_pemesan') ?>

    <?= $form->field($model, 'id_ambulans') ?>

    <?= $form->field($model, 'rating_ambulans') ?>

    <?php // echo $form->field($model, 'review_ambulans') ?>

    <?php // echo $form->field($model, 'id_sopir') ?>

    <?php // echo $form->field($model, 'rating_sopir') ?>

    <?php // echo $form->field($model, 'review_sopir') ?>

    <?php // echo $form->field($model, 'waktu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
