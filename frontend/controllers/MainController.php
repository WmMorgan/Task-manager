<?php

namespace frontend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;



class MainController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->can('admin') || $this->isUserAuthor()) {
                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ]
        ];
    }

    protected function isUserAuthor()
    {
        return $this->findModel(\Yii::$app->request->get('id'))->user_id == \Yii::$app->user->id;
    }

}
