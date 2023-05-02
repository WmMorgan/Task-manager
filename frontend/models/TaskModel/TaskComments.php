<?php

namespace app\models\TaskModel;

use Yii;

/**
 * This is the model class for table "task_comments".
 *
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $message
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Tasks $task
 */
class TaskComments extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'task_comments';
    }


    public function rules()
    {
        return [
            [['task_id', 'user_id', 'message', 'created_at', 'updated_at'], 'required'],
            [['task_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }
}
