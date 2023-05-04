<?php

namespace frontend\widgets\notification;

use app\models\Notification\Notification;
use app\models\TaskModel\Tasks;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class NotificationWidget extends Widget
{
    private $notification;

    public function init()
    {
        $this->notification = $this->getNotifications();
        parent::init();
    }

    public function run()
    {
        // Register AssetBundle
        return $this->render('_notification', ['model' => $this->notification]);
    }

    /**
     * @return object
     */
    public function getNotifications():object
    {
        $model = Notification::find()->where(['user_id' => \Yii::$app->user->id])->all();

        $data = ArrayHelper::toArray($model, [
            'app\models\Notification\Notification' => [
                'id',
                'user_id',
                'task' => function($noti) {
                    $task = Tasks::findOne($noti->task_id);
                    return [
                        'name' => $task->name,
                        'url' => Url::to(['task/view', 'id' => $task->id])
                    ];
                },
                'message' => function($noti) {
                    return $this->getNotificationMessage($noti->key);
                },
                'created_at'
            ],
        ]);

        return (object) [
            'count' => count($data),
            'data' => $data
        ];
    }

    public function getNotificationMessage($key) {
        $messages = [
          Notification::CREATED_TASK_FOR_RESPONSIBLE => "Вам поставили задачу: ",
          Notification::CHANGE_STATUS_TASK_FROM_RESPONSIBLE => "Пользователь изменил статус задачи: ",
          Notification::CHANGE_STATUS_TASK_FOR_RESPONSIBLE => "Статус вашего задания изменен: "
        ];
        return $messages[$key];
    }
}
