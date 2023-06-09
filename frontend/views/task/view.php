<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TaskModel\Tasks $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile("@web/css/comment.css");
?>


<div class="content">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:d-m-Y / H:i']
            ],
        ],
    ]) ?>

    <?php
    $modelComment = new \app\models\TaskModel\TaskComments();
    echo $this->render('_comment', [
        'model' => $modelComment,
        'task' => $model
    ]) ?>


</div>
