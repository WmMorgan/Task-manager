<?php

namespace frontend\controllers;


use app\models\Notification\Notification;
use yii\web\Controller;


class NotificationController extends Controller
{

    public function actionClear($route) {

        Notification::deleteAll(['user_id' => \Yii::$app->user->id]);
        \Yii::$app->session->setFlash('success', "Уведомление успешно очищен");
        $this->redirect([$route]);

    }

}
