<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Ambulancebooking $model */

$this->title = 'Create Ambulancebooking';
$this->params['breadcrumbs'][] = ['label' => 'Ambulancebookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulancebooking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
