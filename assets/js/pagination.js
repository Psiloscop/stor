 $(function(){
    $('#table').on('click', '#pagination a', function(){
        if($(this).attr('href') === '#')
            return;

        $.ajax({
            type: 'post',
            url: $(this).attr('href'),
            success: function(response) {
                $('#table').html(response);

                //$.scrollTo('#table', {duration: 500});
            },
            error: function() {
                alert('error!');
            }
        });
        
        return false;
    });
});