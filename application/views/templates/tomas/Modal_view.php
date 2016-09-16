<div class="modal-dialog">
    <div class="modal-content">
        <?= form_open($form['url']); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $title; ?></h4>
        </div>
        <div class="modal-body">
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     aria-valuemin="0" aria-valuemax="100"
                     aria-valuenow="0" style="width: 0%;">

                </div>
            </div>
            <span class="load_info">
                Добавлено <b>0</b> студентов
            </span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <?php foreach ($buttons as $button): ?>
                <?php $class = isset($button['classes']) ? implode($button['classes'], '') : ''; ?>
                <button id="<?= $button['id']; ?>" type="button" class="btn btn-primary <?= $class; ?>">
                    <?= $button['title']; ?>
                </button>
            <?php endforeach; ?>
        </div>
        <?= form_close(); ?>
    </div>
</div>