<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TaskModel\Tasks $model */

$this->title = 'Изменить задание: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
