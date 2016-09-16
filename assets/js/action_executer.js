$(function () {
    $('#table, #action_menu, .container').on('click', 'a[class~="action_executer"]', function () {
        $.ajax({
            type: 'post',
            url: $(this).attr('href'),
            success: function (response) {
                response = JSON.parse(response);

                if(response['html'] !== undefined &&
                    response['class'] !== undefined) {
                    $('.' + response['class']).html(response['html']);
                }

                $.prompt(response['message']);
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});