$(function () {
    $('#table').on('click', 'a[class~="submit_row"]', function () {
        var row = $(this).parents('tr');
        var url = $(this).attr('href');
        var inputs = row.find(':input').serialize();

        $.ajax({
            type: 'post',
            url: url,
            data: inputs,
            success: function (response) {
                response = JSON.parse(response);

                if (!response['success']) {
                    for (var field in response['errors']) {
                        var element = row.find('#' + field);

                        element
                            .removeAttr('style')
                            .removeAttr('title')
                            .removeAttr('data-toggle');

                        if (response['errors'][field] !== '') {
                            element.css('border-color', 'red');

                            element
                                .attr('data-toggle', 'tooltip')
                                .attr('title', response['errors'][field]);
                        }
                        else {
                            element.tooltip('destroy');
                        }
                    }

                    $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
                }
                else {
                    var tr = $.parseHTML(response['html']);
                    var row_number = row.find('td:first-child').html();

                    $(tr).find('td:first-child').html(row_number);

                    row.replaceWith(tr);
                }
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});