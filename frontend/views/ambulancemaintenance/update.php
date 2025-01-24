<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceMaintenance $model */

$this->title = 'Update Ambulance Maintenance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ambulance Maintenances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ambulance-maintenance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
