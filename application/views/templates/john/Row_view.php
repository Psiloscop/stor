<tr>
    <td>
        Р
    </td>
    <?php foreach ($fields as $field): ?>
        <td>
            <?php switch ($field['tag']):
                case 'input': ?>
                    <?= form_input($field['attributes']); ?>
                    <?php break; ?>
                <?php case 'select': ?>
                    <?= form_dropdown($field['name'], $field['options'],
                        $field['selected'] ?? NULL, $field['attributes']); ?>
                    <?php break; ?>
                <?php endswitch; ?>
        </td>
    <?php endforeach; ?>
    <td>
        <div class="dropdown clearfix">
            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <?php foreach ($dd_items as $ddi): ?>
                    <li role="presentation">
                        <?php $class = isset($ddi['classes']) ? implode($ddi['classes'], '') : '' ?>
                        <a href="<?= $ddi['url']; ?>" id="<?= $ddi['id']; ?>" class="<?= $class; ?>" role="menuitem" tabindex="-1">
                            <?= $ddi['title']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </td>
</tr>