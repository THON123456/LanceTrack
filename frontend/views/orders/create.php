<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AmbulanceOrder $model */

$this->title = 'Create Ambulance Order';
$this->params['breadcrumbs'][] = ['label' => 'Ambulance Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulance-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
