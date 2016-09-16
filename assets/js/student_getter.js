$(function () {
    $('#modal_content').on('click', 'button[class~="get_students"]', function () {
        var url = $(this).parents('form').attr('action');

        if (!window.XMLHttpRequest) {
            alert("Your browser does not support the native XMLHttpRequest object.");

            return;
        }
        try {
            var xhr = new XMLHttpRequest();
            xhr.previous_text = '';

            xhr.onerror = function () {
                alert("[XHR] Fatal Error.");
            };

            xhr.onreadystatechange = function () {
                try {
                    if (xhr.readyState == 4) {
                        //alert('[XHR] Done')
                    }
                    else if (xhr.readyState > 2) {
                        var json_response = xhr.responseText.substring(xhr.previous_text.length);
                        var array_response = JSON.parse(json_response);
                        var counter = $('#modal_content .load_info b');
                        var percent = Math.round(array_response['current'] * 100 / array_response['amount']);

                        $('#modal_content .progress-bar')
                            .attr('aria-valuenow', percent)
                            .css('width', percent + '%')
                            .text(percent + '%');

                        counter.text(array_response['count']);

                        xhr.previous_text = xhr.responseText;
                    }
                }
                catch (e) {
                    //alert("[XHR STATECHANGE] Exception: " + e);
                }
            };

            xhr.open("GET", url, true);
            xhr.send();
        }
        catch (e) {
            alert("[XHR REQUEST] Exception: " + e);
        }

        return false;
    });
});