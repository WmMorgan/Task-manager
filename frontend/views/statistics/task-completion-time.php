<?php

use app\models\TaskModel\Tasks;
use app\models\User;

$this->title = "Среднее время выполнения задачи";
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="content">

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Среднее время выполнения задачи</strong>
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                    <tr>
                        <th class="serial">#</th>
                        <th>ID</th>
                        <th>Юзернейм</th>
                        <th>Пользователь тратит в среднем</th>
                        <th>Количество задач</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    for($i = 0; $i < count($days); $i++):

                        ?>
                        <tr>
                            <td class="serial"><?= $i ?>.</td>
                            <td> <?= $days[$i]['userid'] ?> </td>
                            <td>  <span class="name"><?= User::findOne($days[$i]['userid'])->username ?></span> </td>
                            <td> <span class="date"><?= $days[$i]['time'] ?></span> </td>
                            <td><span class="count"><?= Tasks::find()->where(['responsible' => $days[$i]['userid']])->count() ?></span></a></td>
                        </tr>
                    <?php endfor; ?>
                    <?php
                    if (empty($days)) {
                        echo "<tr><td>Пусто</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div> <!-- /.table-stats -->
        </div>
    </div>

</div>
