<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Зарегистрироваться';
?>


<div class="login-content">
    <div class="login-logo">
        <a href="<?= Yii::$app->homeUrl ?>">
            <img class="align-content" src="<?= Yii::getAlias('@web/images/logo.png') ?>" alt="">
        </a>
    </div>
    <div class="login-form">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="form-group">
                <label>User Name</label>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false) ?>
            </div>
            <div class="form-group">
                <label>Email address</label>
                <?= $form->field($model, 'email')->label(false) ?>
            </div>
            <div class="form-group">
                <label>Password</label>
                <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
            </div>

        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-flat m-b-30 m-t-30', 'name' => 'signup-button']) ?>

        <br>
            <div class="register-link m-t-15 text-center">
                <p>Уже есть аккаунт? <?= Html::a('Войти', ['/']) ?></p>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


