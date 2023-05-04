<?php

namespace frontend\controllers;

use app\models\TaskModel\SearchTask;
use yii\filters\AccessControl;

class MyTasksController extends TaskController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['view', 'change-status'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if ($this->isUserResponsible($action->id)) {
                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SearchTask(['scenario' => 'responsible']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    protected function isUserResponsible($action)
    {

        if ($action == 'view') {
            $id = \Yii::$app->request->get('id');
        } elseif ($action == 'change-status') {
            $id = \Yii::$app->request->post('editableKey');
        }
        return $this->findModel($id)->responsible == \Yii::$app->user->id;

    }

}
