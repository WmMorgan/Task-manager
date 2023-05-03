<?php

namespace app\models;

class User extends \common\models\User
{

    public static function getUsers() {
        $model = self::find()->all();

        return $model;
    }


}