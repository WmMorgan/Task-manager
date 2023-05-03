<?php

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = ArrayHelper::map(User::getUsers(),'id','username');
    $params = [
        'prompt' => 'Выберите ответственное юзера'
    ];
    echo $form->field($model, 'responsible')->dropDownList($items, $params) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->widget(DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
        'options' => ['class' => 'form-control']
]) ?>

    <?= $form->field($model, 'status')->dropDownList(\app\models\TaskModel\Tasks::getStatus()) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранять', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
