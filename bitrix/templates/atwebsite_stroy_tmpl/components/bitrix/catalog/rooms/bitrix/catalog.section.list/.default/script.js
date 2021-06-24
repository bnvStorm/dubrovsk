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