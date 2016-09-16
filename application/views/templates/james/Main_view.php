<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-header">
                <h2><?= $title; ?></h2>
            </div>
            <?php require_once 'Table_view.php'; ?>
        </div>
        <div class="col-md-3">
            <div class="page-header">
                <h2>Меню</h2>
            </div>
            <?php require_once 'Menu_view.php'; ?>
        </div>
    </div>
</div>