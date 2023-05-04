<?php

use app\models\TaskModel\Tasks;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;


$this->title = 'Задания, назначенные вам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => function ($data) {
                    return $data->getUser()->one()->username .' (ID: '.$data->user_id.')';
                }
            ],
            [
                'attribute' => 'responsible',
                'value' => function ($data) {
                    return $data->getResponsible();
                }
            ],
            'name',
            [
                'attribute' => 'deadline',
                'value' => function ($val) {
                    return '<i class="fa fa-calendar-minus-o" aria-hidden="true" style="color: red; font-size: 22px;"></i>
' . date('d.m.Y', $val->deadline);
                },
                'format' => 'raw'
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
//                'readonly' => false,
                'value' => function ($model) {
                    return $model->status;
                }, // assign value from getProfileCompany method
                'editableOptions' => [
                    'inlineSettings' => [
                        'templateBefore' => Editable::INLINE_BEFORE_2,
                        'templateAfter' =>  Editable::INLINE_AFTER_2
                    ],
                    'asPopover' => false,
                'formOptions' => ['action' => ['change-status']],
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => Tasks::getStatus(),
                    'displayValueConfig' => Tasks::getStatus(),
                    'defaultSubmitBtnIcon' => '<i class="fa fa-floppy-o" aria-hidden="true"></i>',
                    'defaultResetBtnIcon' => '<i class="fa fa-repeat" aria-hidden="true"></i>',
                ],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d-m-Y / H:i']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tasks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view}'
            ],
        ],
    ]); ?>


</div>
