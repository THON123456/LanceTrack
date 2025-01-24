<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ambulance $model */

$this->title = 'Update Ambulance: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Ambulances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ambulance, 'url' => ['view', 'id_ambulance' => $model->id_ambulance]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ambulance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
