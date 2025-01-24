<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Ambulance;
use frontend\models\AmbulanceLocation;

class AmbulanceLocationController extends Controller
{

    public $layout = 'main_after_login';

    // ...actions

    public function actionViewLocation()
    {
        return $this->render('view-location');
    }

    public function actionGetAmbulances()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $ambulances = Ambulance::find()->all();
        return $ambulances;
    }

    // AmbulanceTrackingController.php
public function actionCheckNewTrackings()
{
    $newTrackings = AmbulanceLocation::find()->where(['status' => 'new'])->count();
    return $this->asJson(['newTrackings' => $newTrackings]);
}
}
