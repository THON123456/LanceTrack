<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reviews $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pemesan')->textInput() ?>

    <?= $form->field($model, 'id_ambulans')->textInput() ?>

    <?= $form->field($model, 'rating_ambulans')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'review_ambulans')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_sopir')->textInput() ?>

    <?= $form->field($model, 'rating_sopir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'review_sopir')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'waktu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
