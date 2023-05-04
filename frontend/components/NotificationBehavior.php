<?php

namespace app\components;

use app\models\Notification\Notification;
use app\models\TaskModel\Tasks;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class NotificationBehavior extends Behavior
{

    protected $_model;

    /**
     * Binds functions 'afterInsert' and 'afterUpdate' to their respective events.
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    /**
     * This function will be executed when an EVENT_AFTER_INSERT is fired
     */
    public function afterInsert($event)
    {
        $model = $this->findModel();
        $model->setAttributes([
            'user_id' => $event->sender->responsible,
            'task_id' => $event->sender->id,
            'key' => Notification::CREATED_TASK_FOR_RESPONSIBLE
        ]);


        if (!$model->save()) {
            throw new BadRequestHttpException('Валидации не прошла: ' .
                implode("\n", ArrayHelper::getColumn($model->errors, 0, false)));
        }

    }

    /**
     * This function will be executed when an EVENT_AFTER_UPDATE is fired
     */
    public function afterUpdate($event)
    {
        if (array_key_exists("status", $event->changedAttributes)) {

            if (\Yii::$app->user->id == $event->sender->user_id) {

                $status = Notification::CHANGE_STATUS_TASK_FOR_RESPONSIBLE;
                $noti_for_id = $event->sender->responsible;

            } else {
                $noti_for_id = $event->sender->user_id;
                $status = Notification::CHANGE_STATUS_TASK_FROM_RESPONSIBLE;
            }

            $model = $this->findModel();
            $model->setAttributes([
                'user_id' => $noti_for_id,
                'task_id' => $event->sender->id,
                'key' => $status
            ]);

            if (!$model->save()) {
                throw new BadRequestHttpException('Валидации не прошла: ' .
                    implode("\n", ArrayHelper::getColumn($model->errors, 0, false)));
            }
        }
    }


    /**
     * @param null $id
     * @return Notification|null
     */
    public function findModel($id = null)
    {
        if ($this->_model == null) {
            if ($id == null)
                $this->_model = new Notification();
            else
                $this->_model = Notification::find()->where(['user_id' => $id])->all();
        }

        return $this->_model;
    }

}
