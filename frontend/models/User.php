<?php

namespace app\models;


class User extends \common\models\User
{

    public static function getUsers() {
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

    public static function getAvatar($name)
    {
        $get = 'https://ui-avatars.com/api/?name='.$name.'&rounded=true&background=random';
        return $get;
    }


}