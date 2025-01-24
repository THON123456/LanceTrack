<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Notification;

class NotificationController extends Controller
{
    public function actionCheckNew()
    {
        $newNotificationsCount = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
        return $this->asJson(['newNotificationsCount' => $newNotificationsCount]);
    }

    public function actionIndex()
    {
        $notifications = Notification::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->renderPartial('notification', ['notifications' => $notifications]);
    }
}

