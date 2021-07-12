
; /* Start:"a:4:{s:4:"full";s:108:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/form.result.new/order-form/script.js?16229702072789";s:6:"source";s:93:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/form.result.new/order-form/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
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


/* End */
;
; /* Start:"a:4:{s:4:"full";s:94:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/script.js?1622970207130";s:6:"source";s:80:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(function(){
    $('body').on("change", "[name=UF_STATUS]", function(){
        $("#UF_STATUS").trigger("click");
    });
});
/* End */
;
; /* Start:"a:4:{s:4:"full";s:132:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/bitrix/catalog.section.list/.default/script.js?16229702076584";s:6:"source";s:117:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/bitrix/catalog.section.list/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(function(){
    $('body').on('click', '.rooms-show-hide:eq(0)', function(event) {
        $('body').find('.rooms-show-hide').eq(0).removeClass('opened');
        $('body').find('.rooms-show-hide').eq(1).addClass('opened');
        $('body').find('.choose-room .rooms-list .bx_sitemap_ul').slideToggle();
    });
    
    $('body').on('click', '.rooms-show-hide:eq(1)', function(event) {
        $('body').find('.rooms-show-hide').eq(0).addClass('opened');
        $('body').find('.rooms-show-hide').eq(1).removeClass('opened');
        $('body').find('.choose-room .rooms-list .bx_sitemap_ul').slideToggle();
    });

    $('body').on('mousedown', '.smart-filter .interval', function(event) {
        $(this).addClass('changed');
    });

    $(document).on('mouseup', function(event) {
        if ($('body').find('.smart-filter .interval').hasClass('changed')) {
            let newUrl;
            let minSquare = $('body').find('[data-uf=UF_SQUARE] .min-value').text();
            let maxSquare = $('body').find('[data-uf=UF_SQUARE] .max-value').text();
            let minPrice = $('body').find('[data-uf=UF_PRICE] .min-value').text();
            let maxPrice = $('body').find('[data-uf=UF_PRICE] .max-value').text();
            let linkOnclick = $('body').find('.smart-filter .change-interval-value:eq(0)').attr('onclick');
            let arrParams = linkOnclick.split("'");
            $('body').find('.smart-filter .interval').removeClass('changed');
            newUrl = getActionUrl(arrParams[1], 'SQUARE_MIN', minSquare);
            newUrl = getActionUrl(newUrl, 'SQUARE_MAX', maxSquare);
            newUrl = getActionUrl(newUrl, 'PRICE_MIN', minPrice);
            newUrl = getActionUrl(newUrl, 'PRICE_MAX', maxPrice);
            newUrl = arrParams[0]+"'"+newUrl+"'"+arrParams[2]+"'"+arrParams[3]+"'"+arrParams[4];
            $('body').find('.smart-filter .change-interval-value:eq(0)').attr('onclick', newUrl).trigger('click');
        }
    });

    $('body').find('#go-to-flat').on('click', function () {
        let dataId = $(this).attr('data-id');
        chooseSingleHouse(dataId);
    });
    
    $('body').on('click', '.choose-room .room-status.free', function(event) {
        event.preventDefault();
        console.log(1);
        if ($(event.target).hasClass('free')) { 
            $('body').find('.popup-form-order').fadeIn();
        }
    });
    
    $('body').on('click', '.cm-statuses > span', function(event){
        let block = $(event.target).closest('div');
        let url = BX.message('SITE_DIR')+'bitrix24/index.php';
        let option = block.find(':selected');
        
        let reqParams = {
            action: 'changeStatus',
            params: {
                statusId: option.val(),
                sectionId: $('#sectionId').val()
            }
        };
        let classList = {
            STROY_FREE: 'free',
            STROY_ORDER: 'order',
            STROY_SELL: 'cell'
        };
        let code = option.attr('data-code');
        
        var text = option.text(); 
        var newClass = classList[code];
        
        $.post(url, reqParams, function(response) {
            response = JSON.parse(response);
            if (response.success == false || response.success == 'false') { return; }
            $('.rooms-detail .room-status').removeClass(['free', 'order', 'cell'])
                .addClass(newClass).text(text);
        });
    });
    
    if ($('.choose-room .rooms-list .bx_sitemap_ul li').length == 0) {
        $('.choose-room .rooms-selector .alert-message').show();
    } else {
        $('.choose-room .rooms-selector .alert-message').hide();
    }
    $('body').on('click', '.choose-room .right-side .room-status', function(event){
        event.preventDefault();
        event.stopPropagation(); 
        let detailInfoHtml = $('body').find('.choose-room .rooms-selector .detail-info').html();
        let detailInfoText = $('body').find('.choose-room .rooms-selector .detail-info').text();
        $('body').find('.popup-form-order [data-name=id]').val($('#sectionId').val());
        $('body').find('.popup-form-order [data-name=detail]').val(detailInfoText);
        $('body').find('.popup-form-order .detail-info').html(detailInfoHtml);
    });
    $('.choose-room .smart-filter h4').each(function(index, el) {
    	if ($(this).text() == 'hidden') $(this).height('0');
    });

    function changePropsLocation() {
    	if ($(window).width() < 600) {
            let propBlock = $('body').find('.choose-room .rooms-detail .properties').detach();
            $('body').find('.choose-room .rooms-detail').append(propBlock);
        } else {
            let propBlock = $('body').find('.choose-room .rooms-detail .properties').detach();
            $('body').find('.choose-room .rooms-detail .right-side').append(propBlock);
        }
    }
    changePropsLocation();
    $(window).resize(function(event) {
	    changePropsLocation();
    });

    function getParamsList(paramsList = window.location.search) {
        let getList = new Object();
        if (paramsList == "") return getList;
        paramsList = paramsList.substring(2).split("&");
        for (let i = 0; i < paramsList.length; i++) {
        param = paramsList[i].split("=");
            getList[param[0]] = param[1];
        }
        return getList;
    }

    function getActionUrl(url, param, value) {
        let $_GET = getParamsList(url);
        let actionUrl = "";
        if ($.isEmptyObject($_GET)) {
            actionUrl = param+'='+value;
        } else {
            $_GET[param] = value;
            for (let code in $_GET) {
                actionUrl += code+'='+$_GET[code]+'&';
            }
            actionUrl = BX.message('SITE_DIR')+'?'+actionUrl.substring(0, actionUrl.length - 1);
        }
        return actionUrl;
    }

    function chooseSingleHouse(dataId) {
        let newUrl, house, index;
        $('body').find('.choose-room a[id^=house_]').each(function (i, el) {
           if ($(this).attr('id') == 'house_'+dataId) {
               house = $(this);
               index = i;
           }
        });

        let linkOnclick = house.attr('onclick');
        let leftSide = linkOnclick.split("?");
        let rightSide = linkOnclick.split("bxajaxid");

        newUrl = leftSide[0] + "?" + 'SECTION_ID['+index+']='+dataId+'&bxajaxid'+ rightSide[1];
        house.attr('onclick', newUrl).trigger('click');
    }
});
/* End */
;
; /* Start:"a:4:{s:4:"full";s:85:"/bitrix/components/at/interactive.editor/templates/.default/script.js?162297020814190";s:6:"source";s:69:"/bitrix/components/at/interactive.editor/templates/.default/script.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
$(function() {
	jQuery.browser = {};
	jQuery.browser.mozilla=/mozilla/.test(navigator.userAgent.toLowerCase())&&!/webkit/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.webkit=/webkit/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.opera=/opera/.test(navigator.userAgent.toLowerCase());
	jQuery.browser.msie=/msie/.test(navigator.userAgent.toLowerCase());

    // set area position
    $(document).ready(function() {
        let currentSection = $('.interactive-image').attr('data-id');
        if (currentSection) $('.interactive-image .sections-list li[data-id='+currentSection+']').addClass('active');
        setAreaPosition();
    });
    $(window).resize(function() {
        setImageHeight();
        setAreaPosition();
    });

    // show hints by hover on polygon
	$('body').find('.interactive-image').mousemove(function(event){
		let leftPos = event.clientX + 15;
        let topPos = event.clientY + 25;
        $('.interactive-image .hover-title').css({
            "top" : topPos,
            "left" : leftPos
        });
	});

    $('body').find('.interactive-image polygon').mouseenter(function(event) {
        let hoverTitle = $(this).attr('title');
        $('.interactive-image .hover-title').html(hoverTitle).show();
        event.stopPropagation();
    });

    $('.interactive-image polygon').mouseleave(function(event) {
        $('.interactive-image .hover-title').hide().html("");
    });

    $('body').find('.interactive-image polygon').hover(function() {
        $(this).removeClass('transparent');
    }, function() {
        $(this).addClass('transparent');
    });

    $('.interactive-image .area-list .list-item').mouseenter(function(event) {
        let areaId = $(this).attr('data-id');
        $('.interactive-image svg polygon').trigger('mouseleave');
        $('.interactive-image svg polygon[data-id='+areaId+']').trigger('mousemove').trigger('mouseenter');
    });

    // change section
    $('.interactive-image').on('click', '.sections-container', function(event) {
        if ($(this).hasClass('opened')) {
            $('.interactive-image .sections-list li').removeClass('active');

            if (event.target.classList.contains("list-item")) {
                event.target.parentElement.className = 'active';
            }
            let marginTop = '-'+$('.interactive-image .sections-container .active').position().top+'px';

            $('.interactive-image .sections-list').css({
                'margin-top': marginTop,
            });
            $('.interactive-image .sections-list .list-item:eq(0) i').html('&#9660;');
            let selectItemId = $('.interactive-image .sections-list .active').attr('data-id');
            if (selectItemId) document.location.href = getActionUrl('image_section_id', selectItemId);
        } else {
            $('.interactive-image .sections-list').css({
                'margin-top': '0',
            });
            $('.interactive-image .sections-list .list-item:eq(0) i').html('&#9650;');
        }
        $(this).toggleClass('opened');
    });

    // change image on current section
    $('.interactive-image').on('change', '.form-actions', function(event) {
        $(this).submit();
    });
    $('.interactive-image').on('submit', '.form-actions', function(event) {
        event.preventDefault();
        changeImageInSection();
    });

    // close preview window
    $('.interactive-image').on('click', '.close-window', function(event) {
        $('.interactive-image').attr('data-action', 'addNewObjects');
        $('.interactive-image .menu-item[data-action=addNewObjects]').trigger('click');
        setAreaPosition();
         $('.interactive-image .image-container').css('height', 'auto');
        //$(this).remove();
        closeDetailInfo();
    });

    // actions by click on polygon
    $('body').find('.interactive-image polygon').click(function(event) {
        let sectionId = $(this).attr('data-id');
        let dataCount = $(this).attr('data-count');
        if (dataCount == 0) {
            $('body').find('.interactive-image .buttons-block-1').hide();
        } else {
            $('body').find('.interactive-image .buttons-block-1').show();
        }
        showDetailInfo(sectionId);
        event.stopPropagation();
    });
    $('.interactive-image[data-action=deleteObjects] svg').on('click', 'polygon', function(event) {
        let areaId = $(this).attr('data-id');
        areaEvents('delete', areaId);
        event.stopPropagation();
    });

    // close windows
    $(document).on('click', function(event) {
        if (!$(event.target).closest(".interactive-image .area-data").length) {
            closeDetailInfo();
        }
        if (!$(event.target).closest(".interactive-image .change_section_form .sections-container").length) {
            $('.interactive-image .change_section_form .sections-container').removeClass('opened');
        }
        event.stopPropagation();
    });

    $('.interactive-image .close-page').click(function(event) {
        location.href = '/#anc_visual';
    });

    // -- FUNCTIONS -- //
    let $_GET = (function() {
        let paramsList = window.location.search;
        let getList = new Object();
        if (paramsList == "") return getList;
        paramsList = paramsList.substring(1).split("&");
        for (let i = 0; i < paramsList.length; i++) {
        param = paramsList[i].split("=");
            getList[param[0]] = param[1];
        }
        return getList;
    })();

    function getHintPosition(polygon) {
        let arCoordX = [];
        let arCoordY = [];
        let result = [];
        let arPoints = polygon.attr('points').split(' ');
        for (let pair of arPoints) {
            pairX = pair.split(',')[0];
            pairY = pair.split(',')[1];
            arCoordX.push(pairX);
            arCoordY.push(pairY);
        }
        let minX = Math.min.apply(null,arCoordX);
        let minY = Math.min.apply(null,arCoordY);
        let maxX = Math.max.apply(null,arCoordX);
        let maxY = Math.max.apply(null,arCoordY);
        result = {
            'minX': minX,
            'minY': minY,
            'maxX': maxX,
            'maxY': maxY
        };
        return result;
    }

    function setImageHeight() {
        let imageWidth = $('.interactive-image[data-action=previewImage] .image-container').width();
        let imageHeight = $('.interactive-image[data-action=previewImage] .image-container').height();
        let aspect = imageWidth / $(window).width();

        if (aspect > 1) {
            $('.interactive-image[data-action=previewImage] .image-container').height(imageHeight / aspect);
        }
    }

    function setAreaPosition() {
        let newAreas = [];
        let listAreas = getListAreas();
        let scaleSize = getScaleSize();

        // create new area points
        for (let area of listAreas) {
            let newAreaPoints = '';
            let arrPointsPair = area['UF_POINTS'].split(' ');

            for (let pair of arrPointsPair) {
                newAreaPoints += pair.split(',')[0]*scaleSize+','+pair.split(',')[1]*scaleSize+' ';
            }

            newAreas.push({
                'id': area['ID'],
                'points': newAreaPoints.trim(),
                'color': area['UF_AREA_COLOR'],
                'hover-title': area['~UF_AREA_TITLE'],
            });
        }
        // set new area points
        for (let areas of newAreas) {
            $('.interactive-image svg polygon[data-id='+areas['id']+']').attr('points',areas['points']);
            $('.interactive-image svg polygon[data-id='+areas['id']+']').css({
                'fill': areas['color']
            }).attr('title', areas['hover-title']);
        }
    }

    function getActionUrl(param, value) {
        let paramsList = "";
        if ($.isEmptyObject($_GET)) {
            paramsList = param+'='+value;
        } else {
            $_GET[param] = value;
            for (let code in $_GET) {
                paramsList += code+'='+$_GET[code]+'&';
            }
            paramsList = paramsList.substring(0, paramsList.length - 1);
        }
        let actionlUrl = document.location.protocol + '//' + document.location.host + document.location.pathname + '?' + paramsList
        return actionlUrl;
    }

    function getListAreas() {
        let listAreas = BX.message('LIST_AREAS');
        return listAreas;
    }

    function getScaleSize() {
        let imgOldWidth = BX.message('IMG_CONTAINER_WIDTH');
        let imgNewWidth = $('.interactive-image .image-container').width();
        let scaleSize = imgOldWidth == "" ? 1 : imgNewWidth/imgOldWidth;
        return scaleSize;
    }


    function showDetailInfo(sectionId) {
        let listAreas = getListAreas();
        let areaTitle = "";
        let areaContent = "";
        for (let area of listAreas) {
            if (area['ID'] == sectionId) {
                if (area['~DESCRIPTION'] != "" || area['UF_SHOW_DETAIL'] != "") {
                    let arrListPairs = {};
                    let detailInfoBlock = $('.interactive-image .area-data');
                    let curArea = $('.interactive-image svg polygon[data-id='+sectionId+']');
                    let minX = parseInt(curArea.position().left), maxX = 0, minY = 0;
                    let topPosition, rightPosition, leftPosition;

                    arrListPairs = curArea.attr('points').split(' ');

                    for (let i = 0; i < arrListPairs.length; i++) {
                        let arrPairCoord = arrListPairs[i].split(',');

                        if (minY == 0) {
                            minY = arrPairCoord[1];
                        } else if (minY > arrPairCoord[1]) {
                            minY = arrPairCoord[1];
                        }

                        if (maxX == 0) {
                            maxX = arrPairCoord[0];
                        } else if (maxX < arrPairCoord[0]) {
                            maxX = arrPairCoord[0];
                        }
                    }

                    maxX = parseInt(maxX);
                    minY = parseInt(minY);

                    if (maxX > $('.interactive-image .image-container').width()/2 && $('.interactive-image .image-container').width() > 800) {
                        if (minX > 415) {
                            leftPosition = (minX - 400) + 'px';
                        } else {
                            leftPosition = 10 + 'px';
                        }
                        $('.interactive-image .area-data').removeClass('arrow-hide');
                        $('.interactive-image .area-data').removeClass('flip-horizontal');
                    } else if (maxX <= $('.interactive-image .image-container').width()/2 && $('.interactive-image .image-container').width() > 800) {
                        leftPosition = (maxX + 15) + 'px';
                        $('.interactive-image .area-data').removeClass('arrow-hide');
                        $('.interactive-image .area-data').addClass('flip-horizontal');
                    } else if ($('.interactive-image .image-container').width() > 400) {
                        leftPosition = $('.interactive-image .image-container').width()/4 + 'px';
                        $('.interactive-image .area-data').removeClass('flip-horizontal');
                        $('.interactive-image .area-data').addClass('arrow-hide');
                    } else {
                        leftPosition = 15 + 'px';
                        $('.interactive-image .area-data').removeClass('flip-horizontal');
                        $('.interactive-image .area-data').addClass('arrow-hide');
                    }

                    if (minY > 145) {
                        topPosition = minY+'px';
                    } else {
                        topPosition = (minY+50)+'px';;
                    }

                    let infoRooms = {
                        sum: area['ROOM_COUNT'],
                        free: area['ROOM_FREE'],
                        order: area['ROOM_ORDER'],
                        sell: area['ROOM_SELL'],
                        room_0: area['ROOM_0'],
                        room_1: area['ROOM_1'],
                        room_2: area['ROOM_2'],
                        room_3: area['ROOM_3'],
                        room_4: area['ROOM_4'],
                    };

                    if (area['UF_SHOW_DETAIL'] != "") {
                        for (let key in infoRooms) {
                            if (infoRooms[key]) {
                                $('.interactive-image .area-data .content-text-compute .rooms.'+key+' span').text(infoRooms[key]);
                                $('.interactive-image .area-data .content-text-compute .rooms.'+key).show();
                            }
                            $('.interactive-image .area-data .content-text-compute').show();
                        }
                    } else {
                        $('.interactive-image .area-data .content-text-compute').hide();
                        $('.interactive-image .area-data .content-text-compute .rooms').hide();
                        $('.interactive-image .area-data .content-text-compute .rooms span').text('');
                    }

                    $('.interactive-image .area-data .content-text').html(area['~DESCRIPTION']);
                    $('#go-to-flat').attr('data-id', sectionId);

                    detailInfoBlock.show();
                    detailInfoBlock.css({
                        top: topPosition,
                        left: leftPosition
                    });
                }
            }
        }
    }

    function closeDetailInfo() {
        $('.interactive-image .area-data').hide().find('.interactive-image .area-data .content-text').html('');
    }

});
/* End */
;
; /* Start:"a:4:{s:4:"full";s:93:"/bitrix/components/at/interactive.editor/templates/.default/js/colorpicker.js?162297020817175";s:6:"source";s:77:"/bitrix/components/at/interactive.editor/templates/.default/js/colorpicker.js";s:3:"min";s:0:"";s:3:"map";s:0:"";}"*/
/**
 *
 * Color picker
 * Author: Stefan Petre www.eyecon.ro
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
(function ($) {
	var ColorPicker = function () {
		var
			ids = {},
			inAction,
			charMin = 65,
			visible,
			tpl = '<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div></div>',
			defaults = {
				eventName: 'click',
				onShow: function () {},
				onBeforeShow: function(){},
				onHide: function () {},
				onChange: function () {},
				onSubmit: function () {},
				color: 'ff0000',
				livePreview: true,
				flat: false
			},
			fillRGBFields = function  (hsb, cal) {
				var rgb = HSBToRGB(hsb);
				$(cal).data('colorpicker').fields
					.eq(1).val(rgb.r).end()
					.eq(2).val(rgb.g).end()
					.eq(3).val(rgb.b).end();
			},
			fillHSBFields = function  (hsb, cal) {
				$(cal).data('colorpicker').fields
					.eq(4).val(hsb.h).end()
					.eq(5).val(hsb.s).end()
					.eq(6).val(hsb.b).end();
			},
			fillHexFields = function (hsb, cal) {
				$(cal).data('colorpicker').fields
					.eq(0).val(HSBToHex(hsb)).end();
			},
			setSelector = function (hsb, cal) {
				$(cal).data('colorpicker').selector.css('backgroundColor', '#' + HSBToHex({h: hsb.h, s: 100, b: 100}));
				$(cal).data('colorpicker').selectorIndic.css({
					left: parseInt(150 * hsb.s/100, 10),
					top: parseInt(150 * (100-hsb.b)/100, 10)
				});
			},
			setHue = function (hsb, cal) {
				$(cal).data('colorpicker').hue.css('top', parseInt(150 - 150 * hsb.h/360, 10));
			},
			setCurrentColor = function (hsb, cal) {
				$(cal).data('colorpicker').currentColor.css('backgroundColor', '#' + HSBToHex(hsb));
			},
			setNewColor = function (hsb, cal) {
				$(cal).data('colorpicker').newColor.css('backgroundColor', '#' + HSBToHex(hsb));
			},
			keyDown = function (ev) {
				var pressedKey = ev.charCode || ev.keyCode || -1;
				if ((pressedKey > charMin && pressedKey <= 90) || pressedKey == 32) {
					return false;
				}
				var cal = $(this).parent().parent();
				if (cal.data('colorpicker').livePreview === true) {
					change.apply(this);
				}
			},
			change = function (ev) {
				var cal = $(this).parent().parent(), col;
				if (this.parentNode.className.indexOf('_hex') > 0) {
					cal.data('colorpicker').color = col = HexToHSB(fixHex(this.value));
				} else if (this.parentNode.className.indexOf('_hsb') > 0) {
					cal.data('colorpicker').color = col = fixHSB({
						h: parseInt(cal.data('colorpicker').fields.eq(4).val(), 10),
						s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
						b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
					});
				} else {
					cal.data('colorpicker').color = col = RGBToHSB(fixRGB({
						r: parseInt(cal.data('colorpicker').fields.eq(1).val(), 10),
						g: parseInt(cal.data('colorpicker').fields.eq(2).val(), 10),
						b: parseInt(cal.data('colorpicker').fields.eq(3).val(), 10)
					}));
				}
				if (ev) {
					fillRGBFields(col, cal.get(0));
					fillHexFields(col, cal.get(0));
					fillHSBFields(col, cal.get(0));
				}
				setSelector(col, cal.get(0));
				setHue(col, cal.get(0));
				setNewColor(col, cal.get(0));
				cal.data('colorpicker').onChange.apply(cal, [col, HSBToHex(col), HSBToRGB(col)]);
			},
			blur = function (ev) {
				var cal = $(this).parent().parent();
				cal.data('colorpicker').fields.parent().removeClass('colorpicker_focus');
			},
			focus = function () {
				charMin = this.parentNode.className.indexOf('_hex') > 0 ? 70 : 65;
				$(this).parent().parent().data('colorpicker').fields.parent().removeClass('colorpicker_focus');
				$(this).parent().addClass('colorpicker_focus');
			},
			downIncrement = function (ev) {
				var field = $(this).parent().find('input').focus();
				var current = {
					el: $(this).parent().addClass('colorpicker_slider'),
					max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
					y: ev.pageY,
					field: field,
					val: parseInt(field.val(), 10),
					preview: $(this).parent().parent().data('colorpicker').livePreview					
				};
				$(document).bind('mouseup', current, upIncrement);
				$(document).bind('mousemove', current, moveIncrement);
			},
			moveIncrement = function (ev) {
				ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val + ev.pageY - ev.data.y, 10))));
				if (ev.data.preview) {
					change.apply(ev.data.field.get(0), [true]);
				}
				return false;
			},
			upIncrement = function (ev) {
				change.apply(ev.data.field.get(0), [true]);
				ev.data.el.removeClass('colorpicker_slider').find('input').focus();
				$(document).unbind('mouseup', upIncrement);
				$(document).unbind('mousemove', moveIncrement);
				return false;
			},
			downHue = function (ev) {
				var current = {
					cal: $(this).parent(),
					y: $(this).offset().top
				};
				current.preview = current.cal.data('colorpicker').livePreview;
				$(document).bind('mouseup', current, upHue);
				$(document).bind('mousemove', current, moveHue);
			},
			moveHue = function (ev) {
				change.apply(
					ev.data.cal.data('colorpicker')
						.fields
						.eq(4)
						.val(parseInt(360*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.y))))/150, 10))
						.get(0),
					[ev.data.preview]
				);
				return false;
			},
			upHue = function (ev) {
				fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upHue);
				$(document).unbind('mousemove', moveHue);
				return false;
			},
			downSelector = function (ev) {
				var current = {
					cal: $(this).parent(),
					pos: $(this).offset()
				};
				current.preview = current.cal.data('colorpicker').livePreview;
				$(document).bind('mouseup', current, upSelector);
				$(document).bind('mousemove', current, moveSelector);
			},
			moveSelector = function (ev) {
				change.apply(
					ev.data.cal.data('colorpicker')
						.fields
						.eq(6)
						.val(parseInt(100*(150 - Math.max(0,Math.min(150,(ev.pageY - ev.data.pos.top))))/150, 10))
						.end()
						.eq(5)
						.val(parseInt(100*(Math.max(0,Math.min(150,(ev.pageX - ev.data.pos.left))))/150, 10))
						.get(0),
					[ev.data.preview]
				);
				return false;
			},
			upSelector = function (ev) {
				fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
				$(document).unbind('mouseup', upSelector);
				$(document).unbind('mousemove', moveSelector);
				return false;
			},
			enterSubmit = function (ev) {
				$(this).addClass('colorpicker_focus');
			},
			leaveSubmit = function (ev) {
				$(this).removeClass('colorpicker_focus');
			},
			clickSubmit = function (ev) {
				var cal = $(this).parent();
				var col = cal.data('colorpicker').color;
				cal.data('colorpicker').origColor = col;
				setCurrentColor(col, cal.get(0));
				cal.data('colorpicker').onSubmit(col, HSBToHex(col), HSBToRGB(col), cal.data('colorpicker').el);
			},
			show = function (ev) {
				var cal = $('#' + $(this).data('colorpickerId'));
				cal.data('colorpicker').onBeforeShow.apply(this, [cal.get(0)]);
				var pos = $(this).offset();
				var viewPort = getViewport();
				var top = pos.top + this.offsetHeight;
				var left = pos.left;
				if (top + 176 > viewPort.t + viewPort.h) {
					top -= this.offsetHeight + 176;
				}
				if (left + 356 > viewPort.l + viewPort.w) {
					left -= 356;
				}
				cal.css({left: left + 'px', top: top + 'px'});
				if (cal.data('colorpicker').onShow.apply(this, [cal.get(0)]) != false) {
					cal.show();
				}
				$(document).bind('mousedown', {cal: cal}, hide);
				return false;
			},
			hide = function (ev) {
				if (!isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
					if (ev.data.cal.data('colorpicker').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
						ev.data.cal.hide();
					}
					$(document).unbind('mousedown', hide);
				}
			},
			isChildOf = function(parentEl, el, container) {
				if (parentEl == el) {
					return true;
				}
				if (parentEl.contains) {
					return parentEl.contains(el);
				}
				if ( parentEl.compareDocumentPosition ) {
					return !!(parentEl.compareDocumentPosition(el) & 16);
				}
				var prEl = el.parentNode;
				while(prEl && prEl != container) {
					if (prEl == parentEl)
						return true;
					prEl = prEl.parentNode;
				}
				return false;
			},
			getViewport = function () {
				var m = document.compatMode == 'CSS1Compat';
				return {
					l : window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
					t : window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
					w : window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
					h : window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
				};
			},
			fixHSB = function (hsb) {
				return {
					h: Math.min(360, Math.max(0, hsb.h)),
					s: Math.min(100, Math.max(0, hsb.s)),
					b: Math.min(100, Math.max(0, hsb.b))
				};
			}, 
			fixRGB = function (rgb) {
				return {
					r: Math.min(255, Math.max(0, rgb.r)),
					g: Math.min(255, Math.max(0, rgb.g)),
					b: Math.min(255, Math.max(0, rgb.b))
				};
			},
			fixHex = function (hex) {
				var len = 6 - hex.length;
				if (len > 0) {
					var o = [];
					for (var i=0; i<len; i++) {
						o.push('0');
					}
					o.push(hex);
					hex = o.join('');
				}
				return hex;
			}, 
			HexToRGB = function (hex) {
				var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
				return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
			},
			HexToHSB = function (hex) {
				return RGBToHSB(HexToRGB(hex));
			},
			RGBToHSB = function (rgb) {
				var hsb = {
					h: 0,
					s: 0,
					b: 0
				};
				var min = Math.min(rgb.r, rgb.g, rgb.b);
				var max = Math.max(rgb.r, rgb.g, rgb.b);
				var delta = max - min;
				hsb.b = max;
				if (max != 0) {
					
				}
				hsb.s = max != 0 ? 255 * delta / max : 0;
				if (hsb.s != 0) {
					if (rgb.r == max) {
						hsb.h = (rgb.g - rgb.b) / delta;
					} else if (rgb.g == max) {
						hsb.h = 2 + (rgb.b - rgb.r) / delta;
					} else {
						hsb.h = 4 + (rgb.r - rgb.g) / delta;
					}
				} else {
					hsb.h = -1;
				}
				hsb.h *= 60;
				if (hsb.h < 0) {
					hsb.h += 360;
				}
				hsb.s *= 100/255;
				hsb.b *= 100/255;
				return hsb;
			},
			HSBToRGB = function (hsb) {
				var rgb = {};
				var h = Math.round(hsb.h);
				var s = Math.round(hsb.s*255/100);
				var v = Math.round(hsb.b*255/100);
				if(s == 0) {
					rgb.r = rgb.g = rgb.b = v;
				} else {
					var t1 = v;
					var t2 = (255-s)*v/255;
					var t3 = (t1-t2)*(h%60)/60;
					if(h==360) h = 0;
					if(h<60) {rgb.r=t1;	rgb.b=t2; rgb.g=t2+t3}
					else if(h<120) {rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3}
					else if(h<180) {rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3}
					else if(h<240) {rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3}
					else if(h<300) {rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3}
					else if(h<360) {rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3}
					else {rgb.r=0; rgb.g=0;	rgb.b=0}
				}
				return {r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b)};
			},
			RGBToHex = function (rgb) {
				var hex = [
					rgb.r.toString(16),
					rgb.g.toString(16),
					rgb.b.toString(16)
				];
				$.each(hex, function (nr, val) {
					if (val.length == 1) {
						hex[nr] = '0' + val;
					}
				});
				return hex.join('');
			},
			HSBToHex = function (hsb) {
				return RGBToHex(HSBToRGB(hsb));
			},
			restoreOriginal = function () {
				var cal = $(this).parent();
				var col = cal.data('colorpicker').origColor;
				cal.data('colorpicker').color = col;
				fillRGBFields(col, cal.get(0));
				fillHexFields(col, cal.get(0));
				fillHSBFields(col, cal.get(0));
				setSelector(col, cal.get(0));
				setHue(col, cal.get(0));
				setNewColor(col, cal.get(0));
			};
		return {
			init: function (opt) {
				opt = $.extend({}, defaults, opt||{});
				if (typeof opt.color == 'string') {
					opt.color = HexToHSB(opt.color);
				} else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
					opt.color = RGBToHSB(opt.color);
				} else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
					opt.color = fixHSB(opt.color);
				} else {
					return this;
				}
				return this.each(function () {
					if (!$(this).data('colorpickerId')) {
						var options = $.extend({}, opt);
						options.origColor = opt.color;
						var id = 'collorpicker_' + parseInt(Math.random() * 1000);
						$(this).data('colorpickerId', id);
						var cal = $(tpl).attr('id', id);
						if (options.flat) {
							cal.appendTo(this).show();
						} else {
							cal.appendTo(document.body);
						}
						options.fields = cal
											.find('input')
												.bind('keyup', keyDown)
												.bind('change', change)
												.bind('blur', blur)
												.bind('focus', focus);
						cal
							.find('span').bind('mousedown', downIncrement).end()
							.find('>div.colorpicker_current_color').bind('click', restoreOriginal);
						options.selector = cal.find('div.colorpicker_color').bind('mousedown', downSelector);
						options.selectorIndic = options.selector.find('div div');
						options.el = this;
						options.hue = cal.find('div.colorpicker_hue div');
						cal.find('div.colorpicker_hue').bind('mousedown', downHue);
						options.newColor = cal.find('div.colorpicker_new_color');
						options.currentColor = cal.find('div.colorpicker_current_color');
						cal.data('colorpicker', options);
						cal.find('div.colorpicker_submit')
							.bind('mouseenter', enterSubmit)
							.bind('mouseleave', leaveSubmit)
							.bind('click', clickSubmit);
						fillRGBFields(options.color, cal.get(0));
						fillHSBFields(options.color, cal.get(0));
						fillHexFields(options.color, cal.get(0));
						setHue(options.color, cal.get(0));
						setSelector(options.color, cal.get(0));
						setCurrentColor(options.color, cal.get(0));
						setNewColor(options.color, cal.get(0));
						if (options.flat) {
							cal.css({
								position: 'relative',
								display: 'block'
							});
						} else {
							$(this).bind(options.eventName, show);
						}
					}
				});
			},
			showPicker: function() {
				return this.each( function () {
					if ($(this).data('colorpickerId')) {
						show.apply(this);
					}
				});
			},
			hidePicker: function() {
				return this.each( function () {
					if ($(this).data('colorpickerId')) {
						$('#' + $(this).data('colorpickerId')).hide();
					}
				});
			},
			setColor: function(col) {
				if (typeof col == 'string') {
					col = HexToHSB(col);
				} else if (col.r != undefined && col.g != undefined && col.b != undefined) {
					col = RGBToHSB(col);
				} else if (col.h != undefined && col.s != undefined && col.b != undefined) {
					col = fixHSB(col);
				} else {
					return this;
				}
				return this.each(function(){
					if ($(this).data('colorpickerId')) {
						var cal = $('#' + $(this).data('colorpickerId'));
						cal.data('colorpicker').color = col;
						cal.data('colorpicker').origColor = col;
						fillRGBFields(col, cal.get(0));
						fillHSBFields(col, cal.get(0));
						fillHexFields(col, cal.get(0));
						setHue(col, cal.get(0));
						setSelector(col, cal.get(0));
						setCurrentColor(col, cal.get(0));
						setNewColor(col, cal.get(0));
					}
				});
			}
		};
	}();
	$.fn.extend({
		ColorPicker: ColorPicker.init,
		ColorPickerHide: ColorPicker.hidePicker,
		ColorPickerShow: ColorPicker.showPicker,
		ColorPickerSetColor: ColorPicker.setColor
	});
})(jQuery)
/* End */
;; /* /bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/form.result.new/order-form/script.js?16229702072789*/
; /* /bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/script.js?1622970207130*/
; /* /bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/catalog/rooms/bitrix/catalog.section.list/.default/script.js?16229702076584*/
; /* /bitrix/components/at/interactive.editor/templates/.default/script.js?162297020814190*/
; /* /bitrix/components/at/interactive.editor/templates/.default/js/colorpicker.js?162297020817175*/
