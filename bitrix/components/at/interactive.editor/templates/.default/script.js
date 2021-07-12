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