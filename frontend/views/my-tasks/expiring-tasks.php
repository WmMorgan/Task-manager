<?php
$this->title = "Истекающие задачи";
$this->params['breadcrumbs'][] = ['label' => 'Задания, назначенные вам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="content">

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Истекающие задачи</strong>
        </div>
        <div class="table-stats order-table ov-h">
            <table class="table ">
                <thead>
                <tr>
                    <th class="serial">#</th>
                    <th>Название задачи</th>
                    <th>крайний срок</th>
                    <th>Создан в</th>
                    <th>смотреть</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 0;
                foreach ($model as $row):
                    $i++;
                    ?>
                <tr>
                    <td class="serial"><?= $i ?>.</td>
                    <td> <?= $row['name'] ?> </td>
                    <td>  <span class="name"><?= date('d.m.Y', $row->deadline) ?></span> </td>
                    <td> <span class="product"><?= date('d.m.Y / H:i', $row->created_at) ?></span> </td>
                    <td><a href="<?= \yii\helpers\Url::to(['my-tasks/view', 'id' => $row->id]) ?>"> <span class="badge badge-info"><i class="fa fa-eye" style="font-size: 20px;" aria-hidden="true"></i></span></a></td>
                    <td>
                        <span class="badge badge-warning"><?= $row->getStatus()[$row->status] ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php
                if (empty($model)) {
                    echo '<tr><td>Нет задачи, срок действия которой истекает на следующей неделе </td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div> <!-- /.table-stats -->
    </div>
</div>

</div>
