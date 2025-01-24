<?php

use frontend\models\Biodata;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BiodataSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Biodatas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biodata-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Biodata', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_biodata',
            'nama',
            'alamat',
            'usia',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Biodata $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_biodata' => $model->id_biodata]);
                 }
            ],
        ],
    ]); ?>


</div>
