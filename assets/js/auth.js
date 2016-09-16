$(function(){
    $("#auth_form").on("submit", function(){

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                response = JSON.parse(response);
                
                if(response['success'])
                    location.reload();
                else
                {
                    $('#auth_error b').html(response['message']);

                    $('#auth_error').addClass('in');
                }
            },
            error: function() {
                alert('error!');
            }
        });
        
        return false;
    });
    
    $("#auth_error").on("click", "button", function(){
        $('#auth_error').removeClass('in');
        
        return false;
    });
});