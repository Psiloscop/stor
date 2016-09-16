<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Информация о читателе</span>
                <b style="float: right;"><?= $data['status']; ?></b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label>Фамилия:</label> <span><?= $data['last_name']; ?></span>
                        </div>
                        <div>
                            <label>Имя:</label> <span><?= $data['first_name']; ?></span>
                        </div>
                        <div>
                            <label>Отчество:</label> <span><?= $data['middle_name']; ?></span>
                        </div>
                        <div>
                            <label>Пол:</label> <span><?= $data['gender']; ?></span>
                        </div>
                        <div>
                            <label>Дата рождения:</label> <span><?= $data['birth_date']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label>Факультет:</label> <span><?= $data['faculty']; ?></span>
                        </div>
                        <div>
                            <label>Группа:</label> <span><?= $data['study_group']; ?></span>
                        </div>
                        <div>
                            <label>Форма оплаты:</label> <span><?= $data['payment_form']; ?></span>
                        </div>
                        <div>
                            <label>Форма обучения:</label> <span><?= $data['study_form']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div>
                            <label>Номер ЧБ:</label> <span><?= $data['number']; ?></span>
                        </div>
                        <div>
                            <label>Логин:</label> <span><?= $data['username']; ?></span>
                        </div>
                        <div>
                            <label>Пароль:</label> <span><?= $data['number']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <img src="<?= $data['photo']; ?>" style="max-width: 100px;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Действия
            </div>
            <div class="panel-body reader_tasks">
                <?php foreach($tasks as $task): ?>
                    <?php $classes = isset($task['classes']) ? implode($task['classes'], ' ') : ''; ?>
                    <a href="<?= $task['url']; ?>/<?= $data['id']; ?>" role="button"
                       class="btn btn-block btn-default <?= $classes; ?>"><?= $task['title']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>