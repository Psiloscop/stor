$(function () {
    $('#table').on('click', 'a[class~="del_user"]', function () {
        var row = $(this).parents('tr');

        $.ajax({
            type: 'post',
            url: $(this).attr('href'),
            success: function (response) {
                response = JSON.parse(response);

                $.prompt(response['message'], {
                    focus: 1,
                    buttons: {"Да": true, "Нет": false},
                    submit: function (e, v, m, f) {
                        if (v) {
                            $.ajax({
                                type: 'post',
                                url: response['url'],
                                success: function (response) {
                                    response = JSON.parse(response);

                                    if (response['success']) {
                                        row.remove();
                                    }

                                    $.prompt(response['message']);
                                },
                                error: function () {
                                    alert('error!');
                                }
                            });
                        }
                    }
                });
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});