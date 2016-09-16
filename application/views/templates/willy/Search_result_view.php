<ul class="search_result">
    <div>
        <?php foreach($data as $reader): ?>
            <li>
                <a href="<?= $reader['url']; ?>">
                    <b><?= $reader['FIO']; ?></b><br/><span><?= $reader['description']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </div>
</ul>