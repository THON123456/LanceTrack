<?php

use frontend\models\Ambulancebooking;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AmbulancebookingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ambulancebookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ambulancebooking-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <p>
        <?= Html::a('Create Ambulancebooking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'nama',
            'email:email',
            'Password',
            //'hp',
            //'nik',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Ambulancebooking $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>

<div id="new-order-notification" style="display: none; background-color: yellow; padding: 10px; margin-top: 20px;">
