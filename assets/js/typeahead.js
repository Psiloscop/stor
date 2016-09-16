$(function(){
    $('.search_form input').on('focus', function(){
        $('.search_result')
            .css('display', 'block');

        return false;
    });

    $('.search_form input').on('focusout', function(){
        setTimeout(function(){
            $('.search_result')
                .css('display', 'none');
        }, 250);

        return false;
    });
});