$(function(){
    $('body').find('.popup-form-order input[data-name=phone]').inputmask("+7 (999) 999-9999");

    $('body').find('.popup-form-order form').on('submit', function(event) {
        let name = $('body').find('.popup-form-order input[data-name=name]');
        let phone = $('body').find('.popup-form-order input[data-name=phone]');
        let email = $('body').find('.popup-form-order input[data-name=email]');
        let message = $('body').find('.popup-form-order textarea[data-name=message]');
        let detail = $('body').find('.popup-form-order textarea[data-name=detail]');

        $('body').find('.popup-form-order .info-message').remove();
        $('body').find('textarea, input').removeClass('error');
        if (message.val() != "" && message.val().length > 600) {
            message.addClass('error');
            $('body').find('.popup-form-order form').prepend('<p class="info-message error">'+BX.message('ERR_VALUE_MESSAGE')+'</p>');
            event.preventDefault();
        }
        if (detail.val() == "" || detail.val().length > 600) {
            message.addClass('error');
            event.preventDefault();
        }
        if (email.val() != "" && isValidValue('email', email.val()) == false) {
            email.addClass('error');
            $('body').find('.popup-form-order form').prepend('<p class="info-message error">'+BX.message('ERR_VALUE_EMAIL')+'</p>');
            event.preventDefault();
        }
        if (phone.val() != "" && isValidValue('phone', phone.val()) == false) {
            phone.addClass('error');
            $('body').find('.popup-form-order form').prepend('<p class="info-message error">'+BX.message('ERR_VALUE_PHONE')+'</p>');
            event.preventDefault();
        }
        if (name.val() != "" && isValidValue('name', name.val()) == false) {
            name.addClass('error');
            $('body').find('.popup-form-order form').prepend('<p class="info-message error">'+BX.message('ERR_VALUE_NAME')+'</p>');
            event.preventDefault();
        }
        if ($('body').find('textarea.error, input.error').length == 0) {
            $('body').find('.popup-form-order form').prepend('<p class="info-message success">'+BX.message('RESULT_OK')+'</p>');
        }
    }); 
    
    function isValidValue(type, value) {
        let regexp;  
        switch (type) {
            case 'name': regexp  = new RegExp('^[a-zA-Z'+BX.message('REG_EXP_RUS_RANGE')+'\\s\\-]+$'); break;
            case 'phone': regexp = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){11,14}(\s*)?$/; break;
            case 'email': regexp = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,4}$/; break;
        }
        return regexp.test(value);
    }
});

