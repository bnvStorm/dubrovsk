$(function(){
    let callFormBack   = $('.popup-callback');
    let callForm       = $('#jsGetCallback');
    let formInputPhone = $('#jsGetCallback input[name=phone]');
    let formInputName  = $('#jsGetCallback input[name=name]');
    let callFormBtn    = $('.callback-button a');
    let tmpFormPath    = BX.message('TMP_FORM_PATH');
    let iblockFormID   = BX.message('IBLOCK_FORM_ID');
    let messCallback   = BX.message('MESS_CALLBACK');
    let messOrder      = BX.message('MESS_ORDER');

	let messageCode = [];
	messageCode = {
		"result_err": BX.message('ERR_RESULT'),
        "err_empty_value": BX.message('ERR_EMPTY_VALUE'),
        "err_value_name": BX.message('ERR_VALUE_NAME'),
        "err_value_phone": BX.message('ERR_VALUE_PHONE'),
        "err_value_email": BX.message('ERR_VALUE_EMAIL'),
        "err_value_message": BX.message('ERR_VALUE_MESSAGE'),
		"result_ok": BX.message('RESULT_OK'),
	};

    formInputPhone.inputmask("+7 (999) 999-9999");

    callFormBtn.on('click', function(e){ 
        e.preventDefault();
        $('.result_message').remove();
        callFormBack.fadeIn().css('display', 'flex');
        formInputName.focus(); 
    });
    
    $('.close-popup').click(function() {
        $(this).parents('.popup-callback').fadeOut();
        return false;
    });  
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            callFormBack.fadeOut();
        }
    });
    $(document).click(function(e) {
        if ($(e.target).closest('.popup-callback').length == 0) {
            callFormBack.fadeOut();                    
        }
    });
    callForm.on('submit', function(e){
        e.preventDefault();
        let dataForm;
        let postID = BX.message('POST_ID');
        let postType = BX.message('POST_TYPE');
        let formType = callFormBack.hasClass('call') && !callFormBack.hasClass('order')? 'CALL': 'ORDER';
        let detailInfo = callFormBack.find('.detail-info .text').text();
        dataForm = callForm.serializeArray();
        callForm.find('input[type=text]').focus(function() {
            $(this).css('border-color', '');
            $('.result_message').remove();
        });
        $.ajax({
            url: tmpFormPath + "form.ajax.php",
            type: "POST",
            dataType: 'json',
            data: {
                DATA_FORM: dataForm,
                IBLOCK_ID: iblockFormID, 
                POST_ID: postID, 
                POST_TYPE: postType, 
                FORM_TYPE: formType,
                MESS_CALLBACK: messCallback,
                MESS_ORDER: messOrder,
                DETAIL_INFO: detailInfo
            }
        }).done(function (ajaxResult){       
            $('.result_message').remove();
            if(ajaxResult.result_ok) {
                callForm.append('<p class="result_message success">' + messageCode[ajaxResult.result_ok] + '</p>');
                setTimeout(function(){location.reload()}, 2000);
            } else {
                let errorMessage = '';
                for (let error in ajaxResult.result_err) {
                    errorMessage += messageCode[ajaxResult.result_err[error]]+'<br>'; 
                }
                callForm.append('<p class="result_message error">' + errorMessage + '</p>');
            }               
        }).fail(function (XMLHttpRequest, textStatus, errorThrown){
            $('.result_message').remove();
            callForm.append('<p class="result_message error">'+messageCode["result_err"]+'</p>');
        });
    });
});