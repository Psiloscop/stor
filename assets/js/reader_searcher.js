$(function(){
    $('.container form').on('keyup', 'input', function () {
        var query = $(this).val();
        var url = $(this).parents('form').attr('action');

        if(query.length < 4)
        {
            return false;
        }

        $.ajax({
            type: 'post',
            url: url,
            data: {
                query: query
            },
            success: function (response) {
                response = JSON.parse(response);

                if(response['type'] === 'search_result')
                {
                    $('.search_form ul').remove();
                    $('.search_form').append(response['html']);

                    $('.search_count').text(response['count']);
                }
                else
                {
                    $('.reader_section').html(response['html']);
                }

                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_complete.png')
                    .show();
            },
            beforeSend: function() {
                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_load.gif')
                    .show();
            },
            error: function (xhr, status, error) {
                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_error.png')
                    .show();

                $.prompt(xhr.responseText, {
                    title: 'An error was encountered'
                });
            }
        });

        return false;
    });
});

$(function(){
    $('.search_form').on('click', 'a', function () {
        var url = $(this).attr('href');

        $.ajax({
            type: 'post',
            url: url,
            success: function (response) {
                response = JSON.parse(response);

                $('.reader_section').html(response['html']);

                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_complete.png')
                    .show();
            },
            beforeSend: function() {
                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_load.gif')
                    .show();
            },
            error: function (xhr, status, error) {
                $('.ajax_status')
                    .attr('src', '/assets/img/ajax_error.png')
                    .show();

                $.prompt(xhr.responseText, {
                    title: 'An error was encountered'
                });
            }
        });

        return false;
    });
});