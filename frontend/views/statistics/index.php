<?php
$this->title = "Пользователи";
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="content">

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Пользователи</strong>
            </div>
            <div class="table-stats order-table ov-h">
                <table class="table ">
                    <thead>
                    <tr>
                        <th class="serial">#</th>
                        <th>ID</th>
                        <th>Юзернейм</th>
                        <th>E-mail</th>
                        <th>Зарегистрировано</th>
                        <th>Количество задач</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $i = 0;
                    foreach ($users as $user):
                        $i++;
                        ?>
                        <tr>
                            <td class="serial"><?= $i ?>.</td>
                            <td> <?= $user->id ?> </td>
                            <td>  <span class="name"><?= $user->username ?></span> </td>
                            <td>  <span class="email"><?= $user->email ?></span> </td>
                            <td> <span class="date"><?= date('d.m.Y / H:i', $user->created_at) ?></span> </td>
                            <td><span class="count"><?= $user->getTasks()->count() ?></span></a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php
                    if (empty($users)) {
                        echo "<tr><td>Нет пользователей, создавших более $limit задач </td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div> <!-- /.table-stats -->
        </div>
    </div>

</div>
