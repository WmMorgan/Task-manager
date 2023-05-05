<?php

namespace app\models;


use app\models\TaskModel\Tasks;

class User extends \common\models\User
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUsers()
    {
        $model = self::find()->all();

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskNotifications()
    {
        return $this->hasMany(Notification\Notification::class, ['user_id' => 'id']);
    }

    public static function getAvatar($name = null)
    {
        $name = $name ?? \Yii::$app->user->identity->username;;
        $get = 'https://ui-avatars.com/api/?name=' . $name . '&rounded=true&background=random';
        return $get;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['user_id' => 'id']);
    }


}