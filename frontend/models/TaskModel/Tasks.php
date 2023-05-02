<?php

namespace app\models\TaskModel;

use common\models\User;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $responsible
 * @property string $name
 * @property int $deadline
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property TaskComments[] $taskComments
 * @property User $user
 */
class Tasks extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tasks';
    }


    public function rules()
    {
        return [
            [['user_id', 'name', 'deadline', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'responsible', 'deadline', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'responsible' => 'Responsible',
            'name' => 'Name',
            'deadline' => 'Deadline',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[TaskComments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskComments()
    {
        return $this->hasMany(TaskComments::class, ['task_id' => 'id']);
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
