<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceOrder $model */

$this->title = 'Update Ambulance Order: ' . $model->kode_order;
$this->params['breadcrumbs'][] = ['label' => 'Ambulance Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_order, 'url' => ['view', 'kode_order' => $model->kode_order]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ambulance-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
