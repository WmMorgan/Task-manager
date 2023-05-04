<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Class RbacController
 * @package console\controllers
 * @author C_Morgan
 */
class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $rule = new AdminGroupRule;
        $auth->add($rule);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);

        // another role here...
    }
}