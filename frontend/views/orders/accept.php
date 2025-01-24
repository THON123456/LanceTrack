<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Orders */
/* @var $driverList array */
/* @var $ambulanceList array */

$this->title = 'Pilih Sopir dan Ambulance';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-accept">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="orders-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_ambulans')->dropDownList($ambulanceList, ['prompt' => 'Pilih Ambulance']) ?>

        <?= $form->field($model, 'id_sopir')->dropDownList($driverList, ['prompt' => 'Pilih Sopir']) ?>

        <?= $form->field($model, 'kode_order')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'id_pemesan')->hiddenInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
