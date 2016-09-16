<div id="action_menu">
    <?php foreach($menu_actions as $ma): ?>
        <?php $class = isset($ma['classes']) ? implode($ma['classes'], '') : '' ?>
        <a id="<?= $ma['id']; ?>" href="<?= $ma['url']; ?>" class="btn btn-default btn-block <?= $class; ?>" role="button">
            <?= $ma['title']; ?>
        </a>
    <?php endforeach; ?>
</div>
