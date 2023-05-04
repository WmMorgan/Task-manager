<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TaskModel\Tasks $model */

$this->title = 'Создать задачи';
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
