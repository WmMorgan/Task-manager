<?php

namespace app\models\Notification;

use app\models\User;
use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 * @property int $key
 * @property int $created_at
 *
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{

    const CREATED_TASK_FOR_RESPONSIBLE = 5;
    const CHANGE_STATUS_TASK_FOR_RESPONSIBLE = 10;
    const CHANGE_STATUS_TASK_FROM_RESPONSIBLE = 15;


    public function rules()
    {
        return [
            [['user_id', 'task_id', 'key', 'created_at'], 'required'],
            [['user_id', 'task_id', 'key', 'created_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
            'key' => 'Key',
            'created_at' => 'Created At',
        ];
    }

    public function beforeValidate()
    {
        $this->created_at = time();
        return parent::beforeValidate();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
