<?php

?>
<div class="dropdown for-notification">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"></i>
        <span class="count bg-danger"><?= $model->count ?></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="notification">
        <p class="red">У вас есть <?= $model->count ?> уведомления</p>

        <?php foreach ($model->data as $data): ?>
            <a class="dropdown-item media" href="<?= $data['task']['url'] ?>">
                <i class="fa fa-bell"></i>
                <p><?= $data['message'] . $data['task']['name'] ?></p>
            </a>
        <?php endforeach; ?>
        <hr>
        <div class="d-flex justify-content-end p-3">
            <a href="<?= \yii\helpers\Url::to(['notification/clear', 'route' => Yii::$app->controller->action->getUniqueId()]) ?>"><button type="button" class="btn btn-outline-secondary">Очистить уведомления</button></a>
        </div>
    </div>
</div>
