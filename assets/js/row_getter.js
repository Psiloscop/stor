$(function () {
    $('#table').on('click', 'a[class~="row_getter"]', function () {
        var row = $(this).parents('tr');
        var editing_number = row.find('td:first-child').html();

        $.ajax({
            type: 'post',
            url: $(this).attr('href'),
            success: function (response) {
                var tr = $.parseHTML(response);

                $(tr).find('td:first-child').html(editing_number);

                row.replaceWith(tr);
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});