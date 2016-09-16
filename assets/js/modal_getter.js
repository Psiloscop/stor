$(function () {
    $('#table, #action_menu, .container').on('click', 'a[class~="modal_getter"]', function () {

        $.ajax({
            type: 'post',
            url: $(this).attr('href'),
            success: function (response) {
                $('#modal_content').html(response);

                $("#modal_content").modal('show');
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});