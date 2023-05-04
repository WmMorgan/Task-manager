<?php
namespace console\controllers;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class AdminGroupRule extends Rule
{
    public $name = 'adminGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {

            $group = Yii::$app->user->identity->rights;
            if ($item->name === 'admin') {
                return $group == 10;
            }

        }
        return false;
    }
}