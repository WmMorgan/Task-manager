<?php

use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="task-comment" id="comment">
    <hr>
    <h3>
        Комментарии
    </h3>
    <br>
    <div class="col-lg-6">

        <?php
        $comments = $task->getTaskComments()->all();
        ?>

        <div class="col-lg-12 frame">
            <ul>
                <?php foreach ($comments as $comment):
                    if ($comment->user_id !== Yii::$app->user->id):
                        ?>
                        <li style="width:100%">
                            <div class="msj macro">
                                <div class="avatar"><img class="img-circle" style="width:50%;"
                                                         src="<?= User::getAvatar($comment->getUsername()) ?>"/></div>
                                <div class="text text-l">
                                    <p><?= $comment->message ?></p>
                                    <p><small><?= date('d.m.Y / H:i', $comment->created_at) ?></small></p>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li id="last-<?=$comment->id ?>" style="width:100%;">
                            <div class="msj-rta macro">
                                <div class="text text-r">
                                    <p><?= $comment->message ?></p>
                                    <p><small><?= date('d.m.Y / H:i', $comment->created_at) ?></small></p></div>
                                <div class="avatar" style="padding:0px 0px 0px 10px !important">
                                    <img class="img-circle" style="width:50%;"
                                         src="<?= User::getAvatar($comment->getUsername()) ?>">
                                </div>
                            </div>
                        </li>
                    <?php
                    endif;
                endforeach;
                ?>

            </ul>

            <div>
                <div id="textarea" class="msj-rta macro">
                    <?php $form = ActiveForm::begin([
                        'action' => ['comments/send']
                    ]); ?>
                    <div class="text text-r" style="background:whitesmoke !important">
                        <?= $form->field($model, 'task_id')->label(false)->hiddenInput(['value' => Yii::$app->request->get('id')]) ?>
                        <?= $form->field($model, 'message')->textarea(['class' => 'mytext', 'placeholder' => 'Enter here text...'])->label(false) ?>

                    </div>

                    <div class="chsubmit" style="padding:10px;">
                        <?= Html::submitButton('<i class="fa fa-paper-plane" aria-hidden="true"></i>', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>

</div>