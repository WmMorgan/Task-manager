<?php

namespace frontend\controllers;

use app\models\TaskModel\Tasks;
use app\models\TaskModel\SearchTask;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Tasks model.
 */
class TaskController extends MainController
{

    public function behaviors()
    {
        $access = parent::behaviors();
        $access['access']['rules']['status'] = [
          'actions' => ['change-status'],
          'allow' => true,
          'roles' => ['@']
        ];

        return array_merge(
            $access,
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        $searchModel = new SearchTask();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tasks();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                \Yii::$app->session->setFlash('success', "Задача успешно создана");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            \Yii::$app->session->setFlash('success', "Задача успешно изменена");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionChangeStatus()
    {

        // Check if there is an Editable ajax request
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['hasEditable'])) {
                $model = Tasks::findOne($this->request->post('editableKey'));
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $oldValue = $model->status;
                $newstatus = current($this->request->post('Tasks'))['status'];
                $model->status = $newstatus;
                $value = $model->status;
                if ($model->save(false)) {
                    return ['output' => $value, 'message' => ''];
                } else {
                    return ['output' => $oldValue, 'message' => 'Incorrect Value! Please reenter.'];
                }
            }
        }
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
