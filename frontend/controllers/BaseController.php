<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Notification;
use Yii;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Cek apakah user sudah login
        if (!Yii::$app->user->isGuest) {
            $notifications = Notification::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();
            $this->view->params['notifications'] = $notifications;
        }

        return true;
    }
}
