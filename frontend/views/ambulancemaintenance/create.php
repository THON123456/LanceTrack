<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceMaintenance $model */

$this->title = 'Create Ambulance Maintenance';
$this->params['breadcrumbs'][] = ['label' => 'Ambulance Maintenances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-maintenance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
