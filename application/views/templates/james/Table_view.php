<div id="table">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <?php foreach ($fields as $field): ?>
                <th id="<?= $field['id']; ?>"><?= $field['title']; ?></th>
            <?php endforeach; ?>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php $row_number = floor($this->pagination->cur_page / $this->pagination->per_page) *
            $this->pagination->per_page; ?>
        <?php require_once('Table_row_view.php'); ?>
        </tbody>
    </table>
    <?php require_once 'Pagination_view.php'; ?>
</div>
