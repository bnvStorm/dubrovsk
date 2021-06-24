$(function(){
    // init animation
    new WOW().init();

    $(document).ready(function(){
        $('body header').fadeIn();
        $('body footer').fadeIn();

        calcMainSlideHeight();
        setSliderIndex();
        setSliderBackground();
        setAboutDevBackground();
    });

    $(window).resize(function(event) {
        calcMainSlideHeight();
    });
    $(window).scroll(function(){
        if($(this).scrollTop() > 50) {
            $('header').addClass('scrolling');
        } else {
            $('header').removeClass('scrolling');
        }
    });
    $('.header-menu').click(function(event) {
        $('.main-menu').show(300);
    });
    $('.main-menu .close-menu').click(function(event) {
        $('.main-menu').hide(300);
    });
    $('.main-menu a').click(function(event) {
        setTimeout(function(){
            $('.main-menu').hide(300);
        }, 500);
    });

    $('.callback-button a').on('click', function(e){
        e.preventDefault();
        $('.result_message').remove();
        $('.popup-callback').fadeIn().css('display', 'flex');
        $('body').find('#jsGetCallback label:eq(0) input').focus();
    });

    // show on-top button
    $(window).scroll(function(){
        if($(this).scrollTop() > 500) {
            $('#jsMoveTop').fadeIn(300);
        } else {
            $('#jsMoveTop').fadeOut(300);
        }
    });

    // set email and phone link
    function setPhoneLink(ob) {
        if(ob.attr('href') == '') {
            var phoneNumber = ob.text().replace(/\D+/g, '');
            ob.attr('href', 'tel:'+phoneNumber);
        }
    }
    function setEmailLink(ob) {
        if(ob.attr('href') == '') {
            var emailAddress = ob.text();
            ob.attr('href', 'mailto:'+emailAddress);
        }
    }
    $('header .header-phone a.tel').click(function(){setPhoneLink($(this))});
    // change color-scheme
    let themeEditClass =  $('#jsThemeEdit > i').attr('class');
    $('#jsThemeEdit > i').click(function(){
        if($(this).attr('class') == themeEditClass) {
            $(this).attr('class', 'fa fa-close');
        } else {
            $(this).attr('class', themeEditClass);
        }
        $('#jsThemeSet').toggleClass('d-none');
    });
    $('#jsThemeSet > span').click(function(){
        let curTheme = $(this).attr('data-theme');
        var templatePath = BX.message('TEMPLATE_PATH');
        $.ajax({
            type: "POST",
            url:templatePath+"/ajax/theme-edit.ajax.php",
            data: {curTheme: curTheme, TEMPLATE_PATH: templatePath},
            success:function(data){
                location.reload(true);
            }
        });
    });
    // move theme block
    function moveThemeBlock() {
        let mPress, mPressPos, elPos;
        $('#jsThemeEdit').on('mousedown', function(event){
            mPress = 'Y';
            mPressPos = event.pageY;
            elPos = $(this).position().top;
        });
        $(document).on('mouseup', function(){
            mPress = 'N';
        });
        $('#jsThemeEdit').mousemove(function(event) {
            $(this).css('cursor','move');
            if(mPress == 'Y') $(this).css('top', elPos+event.pageY-mPressPos);
        });
    }
    moveThemeBlock();
    // scroll to anchor
    $('a[href^="/#"]').on('click', function(){
        let delay = 500;
        let hrefLink = $(this).attr('href');
        hrefLink = hrefLink.substr(2, 99);
        if (!hrefLink) { return; }
        $('html, body').stop().animate({scrollTop: $('a[name=' + hrefLink).offset().top - 100}, delay);
    });
    $('a[href^="#"]').on('click', function(){
        let delay = 500;
        let hrefLink = $(this).attr('href');
        hrefLink = hrefLink.substr(1, 99);
        if (!hrefLink) { return; }
        $('html, body').stop().animate({scrollTop: $('a[name=' + hrefLink).offset().top - 100}, delay);
    });
    $('.our-difference .slider-list').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        padding: '20px',
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            },
        ]
    });

    $('.gallery .slider-list').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
    });

    initDocSlider();

    $('.documents .show-more').click(function(event) {
        event.preventDefault();
        if ($('.documents .doc-list .doc-item.d-none').length !== 0) {
            $('.documents .doc-list .doc-item.d-none').each(function(index, el) {
                if (index < 4) $(this).hide().removeClass('d-none').slideDown('400');
            });
            if ($('.documents .doc-list .doc-item.d-none').length == 0) {
                $(this).text('Скрыть все');
            }
        } else {
            $('.documents .doc-list .doc-item').each(function(index, el) {
                if (index > 7) $(this).slideDown('400').addClass('d-none');
            });
            $(this).text('Показать еще');
        }

    });

    function setSliderBackground() {
        let bgSrc = $('.main-slider .bg-image img').attr('src');
        $('.main-slider .slider-item').css('backgroundImage',  'url("'+bgSrc+'")');
    }
    function setAboutDevBackground() {
        let bgSrc = $('.about-dev .bg-image img').attr('src');
        $('.about-dev .content').css('backgroundImage',  'url("'+bgSrc+'")');
    }

    function initDocSlider() {
        $('.license .slider-list').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                },
            ]
        });

        let slideIndex = 0;
        $('.license .slider-list .slick-slide').each(function() {
            if (!$(this).hasClass('slick-cloned')) {
                $(this).find('.slider-item').each(function(){
                    $(this).attr('data-index', slideIndex);
                    slideIndex++;
                });
            }
        });

        $('.license .slider-list .slider-item').click(function(event) {
            let slideIndex = $(this).attr('data-index');
            showDocGalleryModal(slideIndex);
        });

        $('.license .slider-modal button').click(function(event) {
            let action = $(this).attr('data-action');
            let curIndex = $(this).parent('.slider-modal').find('.wrapper img').attr('data-index');
            let prevIndex;
            let nextIndex;
            let slideCount = 0;
            let lastIndex;

            $('.license .slider-list .slick-slide').each(function() {
                if (!$(this).hasClass('slick-cloned')) {
                    $(this).find('.slider-item').each(function(){
                        slideCount++;
                    });
                }
            });
            lastIndex = parseInt(slideCount-1);

            if (curIndex > 0 && curIndex < lastIndex) {
                prevIndex = curIndex-1;
                nextIndex = parseInt(curIndex)+1;
            } else if (curIndex == 0) {
                prevIndex = lastIndex;
                nextIndex = parseInt(curIndex)+1;
            } else {
                prevIndex = curIndex-1;
                nextIndex = 0;
            }

            if (action == 'Prev') {
                setTimeout(function(){
                    $('.license .slider-modal .wrapper').css('left','-110%');
                }, 200);
                setTimeout(function(){
                    $('.license .slider-modal .wrapper').hide().css('left','110%');
                }, 300);
                setTimeout(function(){
                    showDocGalleryModal(prevIndex);
                }, 350);
            } else if (action == 'Next') {
                setTimeout(function(){
                    $('.license .slider-modal .wrapper').css('left','110%');
                }, 200);
                setTimeout(function(){
                    $('.license .slider-modal .wrapper').hide().css('left','-110%');
                }, 300);
                setTimeout(function(){
                    showDocGalleryModal(nextIndex);
                }, 350);
            }

        });
    }


    $('.gallery .slider-list .slider-item').click(function(event) {
        let slideIndex = $(this).attr('data-index');
        showGalleryModal(slideIndex, curSlider = 'gallery');
    });

    $('.gallery .slider-modal button').click(function(event) {
        let action = $(this).attr('data-action');
        let curIndex = $(this).parent('.slider-modal').find('.wrapper img').attr('data-index');
        changeGallerySlider(action, curIndex, curSlider = 'gallery');
    });

    $('.slider-modal .wrapper').click(function(event) {
        closeSliderModal();
    });
    $('.slider-modal img').click(function(event) {
        event.stopPropagation();
    });
    $('.slider-modal .close-window').click(function(event) {
        closeSliderModal();
    });

    $(document).keyup(function(event){
        if (event.which == 27) {
            closeSliderModal();
        }
    });


    // calculate Main Slide Height
    function calcMainSlideHeight() {
        let mainSlider = $('.main-slider');
        let maxHeight;
        if (parseInt($(window).width()) > parseInt($(window).height())) {
            maxHeight = mainSlider.width()/1.7777;
        } else {
            maxHeight = mainSlider.width()*0.8;
        }
        mainSlider.css('maxHeight', maxHeight);
    }
	// convert IMG to SVG
    function convertImgToSvg(element, height, width) {
        let $img = element;
        let imgClass = $img.attr('class');
        let imgURL = $img.attr('src');
        $.get(imgURL, function(data) {
            let $svg = $(data).find('svg');
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }
            $svg = $svg.removeAttr('xmlns:a');
            $svg.attr('height', '100%');
            $svg.attr('width', '100%');
            $img.replaceWith($svg);
        }, 'xml');
    }
    // gallery-slider functions
    function setSliderIndex() {
        let indexGallery = 0;
        $('.gallery .slider-list .slick-slide').each(function() {
            if (!$(this).hasClass('slick-cloned')) {
                $(this).find('.slider-item').each(function(){
                    $(this).attr('data-index', indexGallery);
                    indexGallery++;
                });
            }
        });
        let indexBuilding = 0;
        $('.building .slider-list .slick-slide').each(function() {
            if (!$(this).hasClass('slick-cloned')) {
                $(this).find('.slider-item').each(function(){
                    $(this).attr('data-index', indexBuilding);
                    indexBuilding++;
                });
            }
        });
    }
    function showGalleryModal(slideIndex, curSlider) {
        let imgSrc;
        if (curSlider == 'gallery') {
            imgSrc = $('.gallery .slider-list .slider-item[data-index='+slideIndex+'] .slider-bg').css('backgroundImage');
            imgSrc = imgSrc.split('"')[1];

            $('.gallery .slider-modal .wrapper').html("").append("<img src='"+imgSrc+"' data-index="+slideIndex+">");
            $('.gallery .slider-modal').fadeIn(400);
            setTimeout(function(){
                $('.gallery .slider-modal .wrapper').fadeIn(200).css('left','0');
            }, 300);
        } else if (curSlider == 'building') {
            imgSrc = $('.building .slider-list .slider-item[data-index='+slideIndex+']').css('backgroundImage');
            imgSrc = imgSrc.split('"')[1];
            $('.building .slider-modal .wrapper').html("").append("<img src='"+imgSrc+"' data-index="+slideIndex+">");
            $('.building .slider-modal').fadeIn(400);
            setTimeout(function(){
                $('.building .slider-modal .wrapper').fadeIn(200).css('left','0');
            }, 300);
        }
    }
    function showDocGalleryModal(slideIndex) {
        let imgSrc = $('.license .slider-list .slider-item[data-index='+slideIndex+'] .slider-bg').css('backgroundImage');
        imgSrc = imgSrc.split('"')[1];

        $('.license .slider-modal .wrapper').html("").append("<img src='"+imgSrc+"' data-index="+slideIndex+">");
        $('.license .slider-modal').fadeIn(400);
        setTimeout(function(){
            $('.license .slider-modal .wrapper').fadeIn(200).css('left','0');
        }, 300);
    }
    function changeGallerySlider(action, curIndex, curSlider) {
        let prevIndex;
        let nextIndex;
        let slideCount = 0;
        let lastIndex;

        if (curSlider == 'gallery') {
            $('.gallery .slider-list .slick-slide').each(function() {
                if (!$(this).hasClass('slick-cloned')) {
                    $(this).find('.slider-item').each(function(){
                        slideCount++;
                    });
                }
            });
            lastIndex = parseInt(slideCount-1);

            if (curIndex > 0 && curIndex < lastIndex) {
                prevIndex = curIndex-1;
                nextIndex = parseInt(curIndex)+1;
            } else if (curIndex == 0) {
                prevIndex = lastIndex;
                nextIndex = parseInt(curIndex)+1;
            } else {
                prevIndex = curIndex-1;
                nextIndex = 0;
            }

            if (action == 'Prev') {
                setTimeout(function(){
                    $('.gallery .slider-modal .wrapper').css('left','-110%');
                }, 200);
                setTimeout(function(){
                    $('.gallery .slider-modal .wrapper').hide().css('left','110%');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(prevIndex, curSlider = 'gallery');
                }, 350);
            } else if (action == 'Next') {
                setTimeout(function(){
                    $('.gallery .slider-modal .wrapper').css('left','110%');
                }, 200);
                setTimeout(function(){
                    $('.gallery .slider-modal .wrapper').hide().css('left','-110%');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(nextIndex, curSlider = 'gallery');
                }, 350);
            }
        } else if (curSlider == 'building') {
            $('.building .slider-list .slick-slide').each(function() {
                if (!$(this).hasClass('slick-cloned')) {
                    $(this).find('.slider-item').each(function(){
                        slideCount++;
                    });
                }
            });
            lastIndex = parseInt(slideCount-1);

            if (curIndex > 0 && curIndex < lastIndex) {
                prevIndex = curIndex-1;
                nextIndex = parseInt(curIndex)+1;
            } else if (curIndex == 0) {
                prevIndex = lastIndex;
                nextIndex = parseInt(curIndex)+1;
            } else {
                prevIndex = curIndex-1;
                nextIndex = 0;
            }

            if (action == 'Prev') {
                setTimeout(function(){
                    $('.building .slider-modal .wrapper').css('left','-110%');
                }, 200);
                setTimeout(function(){
                    $('.building .slider-modal .wrapper').hide().css('left','110%');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(prevIndex, curSlider = 'building');
                }, 350);
            } else if (action == 'Next') {
                setTimeout(function(){
                    $('.building .slider-modal .wrapper').css('left','110%');
                }, 200);
                setTimeout(function(){
                    $('.building .slider-modal .wrapper').hide().css('left','-110%');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(nextIndex, curSlider = 'building');
                }, 350);
            }
        }
    }

    // close Slider Modal
    function closeSliderModal(event) {
        $('.slider-modal').fadeOut();
        $('.slider-modal .wrapper').html("");
    }

    $('[data-fancybox="images"]').fancybox({
        margin : [44,0,22,0],
            thumbs : {
            autoStart : true,
            axis      : 'x'
        }
    });

   // callback-form actions --- start
    $('body').find('.callback-form input').on('click', function(){
        $('.callback-form label').removeClass('active');
        $(this).parent('label').addClass('active');
    });
    $('body').find('.callback-form textarea').on('click', function(){
        $('.callback-form label').removeClass('active');
        $(this).parent('label').addClass('active');
    });
    $(document).on('click', function(event) {
        if ($(event.target).closest('.callback-form').length == 0) {
            closeCallbackForm();
        }
    });
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            closeCallbackForm();
        }
    });
    $('body').find('.callback-form .close-form').on('click', function(event) {
        event.preventDefault();
        closeCallbackForm();
    });
    // callback-form actions --- end

    $('footer .order-button').click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.header__top-line .header-button a').trigger('click');
    });

    function closeCallbackForm() {
        $('body').find('.callback-form').fadeOut();
        $('body').find('.callback-form .info-message').remove();
        $('body').find('.callback-form input[type=text]').removeClass('error').val("");
        $('body').find('.callback-form textarea').removeClass('error').val("");
    }
});