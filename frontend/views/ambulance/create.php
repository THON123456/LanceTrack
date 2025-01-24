<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ambulance $model */

$this->title = 'Create Ambulance';
$this->params['breadcrumbs'][] = ['label' => 'Ambulances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
