$(function () {
    $('#modal_content').on('click', 'button[class~="submit_modal"]', function () {
        var form = $('#modal_content form');

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                response = JSON.parse(response);

                if (!response['success']) {
                    for (var field in response['errors']) {
                        var element = $('#modal_content #' + field);

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
                    var last_number = $('#table tbody:last-child tr:last-child td:first-child').html();

                    $(tr).find('td:first-child').html(parseInt(last_number) + 1);

                    $('#table tbody:last-child').append(tr);

                    $('#modal_content').modal('hide');
                }
            },
            error: function () {
                alert('error!');
            }
        });

        return false;
    });
});