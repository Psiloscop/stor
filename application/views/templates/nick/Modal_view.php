<div class="modal-dialog">
    <div class="modal-content">
        <?= form_open($form['url']); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?= $title; ?></h4>
        </div>
        <div class="modal-body">
            <?php foreach ($fields as $field): ?>
                <div class="form-group">
                    <?php switch ($field['tag']):
                        case 'input': ?>
                            <label for="<?= $field['attributes']['id']; ?>"><?= $field['title']; ?></label>
                            <?= form_input($field['attributes']); ?>
                            <?php break; ?>
                        <?php case 'select': ?>
                            <label for="<?= $field['id']; ?>"><?= $field['title']; ?></label>
                            <?= form_dropdown($field['name'], $field['options'],
                                $field['selected'] ?? NULL, $field['attributes']); ?>
                            <?php break; ?>
                        <?php endswitch; ?>
                </div>
            <?php endforeach; ?>
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