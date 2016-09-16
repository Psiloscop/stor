<?php foreach ($row_data as $rd): ?>
    <tr>
        <td><?= isset($row_number) ? ++$row_number : 0; ?></td>
        <?php foreach ($fields as $field): ?>
            <td><?= $rd[$field['id']]; ?></td>
        <?php endforeach; ?>
        <td>
            <div class="dropdown clearfix">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <?php foreach ($row_actions as $ra): ?>
                        <li role="presentation">
                            <?php
                            $attachment = '';
                            foreach ($row_ids as $ri)
                                $attachment .= '/' . $rd[$ri];
                            $class = isset($ra['classes']) ? implode($ra['classes'], '') : ''
                            ?>
                            <a href="<?= $ra['url'] . $attachment; ?>" class="<?= $class; ?>" role="menuitem" tabindex="-1">
                                <?= $ra['title']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </td>
    </tr>
<?php endforeach; ?>