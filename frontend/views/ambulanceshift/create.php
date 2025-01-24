<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ambulanceshift $model */

$this->title = 'Create Ambulanceshift';
$this->params['breadcrumbs'][] = ['label' => 'Ambulanceshifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulanceshift-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
