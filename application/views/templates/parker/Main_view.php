<div class="container">
    <div class="page-header">
        <h2><?= $title; ?></h2>
    </div>
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($items as $item): ?>
                    <p>
                        <span><?= $item['title'] . ': '; ?></span>
                        <b><?= $data[$item['id']] ?? '-'; ?></b>
                    </p>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <?php foreach ($buttons as $button): ?>
                    <?php $class = isset($button['classes']) ? implode($button['classes'], '') : '' ?>
                    <a id="<?= $button['id']; ?>" href="<?= $button['url']; ?>" class="btn btn-primary btn-block <?= $class; ?>" role="button">
                        <?= $button['title']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>