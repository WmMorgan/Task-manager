<?php


use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Войти';
?>
<div class="login-content">
    <div class="login-logo">
        <a href="<?= Yii::$app->homeUrl ?>">
            <img class="align-content" src="<?= Yii::getAlias('@web/images/logo.png') ?>" alt="">
        </a>
    </div>
    <div class="login-form">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group">
            <label>Username</label>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label(false) ?>
        </div>
        <div class="form-group">
            <label>Password</label>
            <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
        </div>
        <div class="checkbox">
            <label>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </label>
            <label class="pull-right">
                <a href="#">Forgotten Password?</a>
            </label>

        </div>
        <?= Html::submitButton('Войти', ['class' => 'btn btn-success btn-flat m-b-30 m-t-30', 'name' => 'login-button']) ?>

        <div class="register-link m-t-15 text-center">
            <p>Нет аккаунта? <?= Html::a('Зарегистрируйтесь здесь', ['site/signup'], ['class' => 'tx-info']) ?></p>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

