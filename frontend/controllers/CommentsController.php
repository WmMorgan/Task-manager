<?php

namespace frontend\controllers;


use app\models\TaskModel\TaskComments;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CommentsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['send'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionSend()
    {

        $model = new TaskComments();

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {

                $task = $model->getTask()->one();
                $route = $task->responsible == \Yii::$app->user->id ?
                    'my-tasks/view' : 'task/view';

                return $this->redirect(
                    [$route,
                        'id' => \Yii::$app->request->post('TaskComments')['task_id'],
                        '#' => 'last-'.$model->id]);
            }
        }

        throw new BadRequestHttpException('Валидации не прошла: ' .
            implode("\n", ArrayHelper::getColumn($model->errors, 0, false)));

    }

    protected function findModel($id)
    {
        if (($model = TaskComments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
