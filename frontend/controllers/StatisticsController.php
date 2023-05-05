<?php
namespace frontend\controllers;

use app\models\TaskModel\Tasks;
use app\models\User;
use yii\filters\AccessControl;

class StatisticsController extends MainController {

    public $limit = 10;


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin']
                    ],
                ],
            ]
        ];
    }


    public function actionIndex() {

        $models = User::getUsers();

        $users = [];
        foreach ($models as $model) {
            if ($model->getTasks()->count() > $this->limit) {
                $users[] = $model;
            }
        }

       return $this->render('index', [
            'users' => $users,
           'limit' => $this->limit
        ]);
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionTaskCompletionTime()
    {
    $status = Tasks::COMPLETED;
        $models = \Yii::$app->db->createCommand('
SELECT round(avg(tasks.updated_at-tasks.created_at)) as average, `user`.id as userid 
FROM tasks INNER JOIN `user` ON tasks.responsible = `user`.id
WHERE tasks.status = "' . $status . '"
GROUP BY userid HAVING average
')->queryAll();

        $days = [];
        foreach ($models as $model) {
            $daysHours = $this->unixtimeToFormat($model['average']);
            $days[] = ['userid' => $model['userid'], 'time' => $daysHours];
        }
        return $this->render('task-completion-time', [
            'days' => $days
        ]);
    }

    /**
     * @param $seconds
     * @return string
     */
    public function unixtimeToFormat($seconds)
    {

        $days = floor($seconds / 86400);
        $hrs = floor($seconds / 3600);
        $mins = (intval($seconds / 60)) % 60;
        $sec = intval($seconds % 60);

        if ($days > 0) {
            //echo $days;exit;
            $hrs = str_pad($hrs, 2, '0', STR_PAD_LEFT);
            $hours = $hrs - ($days * 24);
            $return_days = $days . " дней ";
            $hrs = str_pad($hours, 2, '0', STR_PAD_LEFT);
        } else {
            $return_days = "";
            $hrs = str_pad($hrs, 2, '0', STR_PAD_LEFT);
        }

        $mins = str_pad($mins, 2, '0', STR_PAD_LEFT);
        $sec = str_pad($sec, 2, '0', STR_PAD_LEFT);

        return $return_days . $hrs . ":" . $mins . ":" . $sec;
    }

}