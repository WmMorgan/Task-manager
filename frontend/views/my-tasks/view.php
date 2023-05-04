<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TaskModel\Tasks $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задания, назначенные вам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile("@web/css/comment.css");

?>
<div class="content">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => "Владелец задачи",
                'value' => $model->getOwner()
            ],
            [
                'label' => "Исполнитель задачи",
                'value' => $model->getResponsible()
            ],
            'name',
            [
                'attribute' => 'deadline',
                'format' => ['datetime', 'php:d-m-Y']
            ],
            [
                'attribute' => 'status',
                'value' => \app\models\TaskModel\Tasks::getStatus()[$model->status]
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d-m-Y / H:i']
            ]
        ],
    ]) ?>
    <?php
    $modelComment = new \app\models\TaskModel\TaskComments();
    echo $this->render('@app/views/task/_comment', [
        'model' => $modelComment,
        'task' => $model
    ]) ?>
</div>
