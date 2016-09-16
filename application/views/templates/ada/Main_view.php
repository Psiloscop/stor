<div class="container">
    <div class="page-header">
        <h2><?= $title; ?></h2>
    </div>
    <section class="search_section">
        <form action="<?= $url; ?>" method="post" class="search_form">
            <input type="text" name="query" placeholder="Введите ФИО или номер ЧБ" />
            <img src="" class="ajax_status" />
        </form>
    </section>
    <hr/>
    <div class="reader_section">
    </div>
</div>