<?php

namespace app\models\TaskModel;

use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

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
    const PROCCESS = 1;
    const COMPLETED = 2;
    const CANCELED = 3;

    public static function tableName()
    {
        return 'tasks';
    }


    public function rules()
    {
        return [
            [['name', 'deadline'], 'required'],
            [['user_id', 'responsible', 'status', 'created_at', 'updated_at'], 'integer'],
            [['deadline'], 'changeToUnixTime'],
            [['name'], 'string', 'max' => 255],
            ['name', 'unique'],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function changeToUnixTime($attribute, $params): bool
    {
        $toUnix = $this->{$attribute};

        if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $toUnix)) {
            $this->{$attribute} = strtotime($toUnix);
            return true;
        } else {
            $this->addError($attribute, 'Формат даты не правильный');
        }

    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'responsible' => 'Ответственный',
            'name' => 'Название задачи',
            'deadline' => 'Крайний срок',
            'status' => 'статус',
            'created_at' => 'Создан в',
            'updated_at' => 'Обновлено в',
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

    /**
     * @return string
     */
    public function getResponsible(): string
    {
        if ($this->responsible == null) {
            return "Не указан";
        } else {
            return \app\models\User::findOne(['id' => $this->responsible])->username;
        }
    }


    public static function getStatus()
    {
        return [
            self::PROCCESS => "в работе",
            self::COMPLETED => "завершено",
            self::CANCELED => "отменено"
        ];
    }
}
