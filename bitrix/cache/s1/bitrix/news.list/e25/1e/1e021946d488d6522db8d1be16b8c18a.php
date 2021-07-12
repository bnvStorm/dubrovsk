<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001625609536';
$dateexpire = '001661609536';
$ser_content = 'a:2:{s:7:"CONTENT";s:8154:"
<div class="date-list">
        <span 
    id="bx_3485106786_36" 
    data-id="36" 
    class="date-item ">
        Фотографии Дубровского городского поселения    </span>
            <span 
    id="bx_3485106786_42" 
    data-id="42" 
    class="date-item active">
        Фото объектов    </span>
    </div>
<div class="slider-list">
    <div class="slider-group"><div class="row-1 row"><div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url(/upload/iblock/ddb/hmwr2slcwj9oy96qkpbn7h1x9p9m76fb.jpg)"></div></div><div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url(/upload/iblock/03d/hdazc925q8jagf0p92pcwi37cfjgn0oj.jpg)"></div></div></div><div class="row-2 row"><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/d1b/20woivx3bbcvwrlo3yyqcv2hai7zojy0.jpg)"></div></div><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/470/3tvklyctjcj17vd97xwla2v85u47qx2x.jpg)"></div></div><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/711/ip1l0d3epqjuyjfiiwe6ugoisrdrl6n3.jpg)"></div></div></div></div><div class="slider-group"><div class="row-1 row"><div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url(/upload/iblock/575/37lz0mbvduulvtqxbnsf2p6f0q1dyyl3.jpg)"></div></div><div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url(/upload/iblock/dc8/29ft02g67utpqcgjgumsnw3dpjn4hoxu.jpg)"></div></div></div><div class="row-2 row"><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/8e4/615prhnzs7i20dtiu9cb2duxl9zyep61.jpg)"></div></div><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/08e/nz1gcn0k9fspr8c2ibj86ihkqvb0wflj.jpg)"></div></div><div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url(/upload/iblock/650/zdiezng0gfcwg2ogh6uyme6dxdqvrou1.jpg)"></div></div></div></div><div class="slider-group"><div class="row-1 row"><div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url(/upload/iblock/103/vqd2xdwo6r5p8650jffwqx6j4eyandm4.jpg)"></div></div></div><div class="row-2 row"></div></div></div>
<div class="slider-modal">
    <span class="close-window"></span>
    <button class="slide-prev slide-arrow" data-action="Prev" type="button" style="">Prev</button>
    <div class="wrapper"></div>
    <button class="slide-next slide-arrow" data-action="Next" type="button" style="">Next</button>
</div>
<script>
    $(function(){
        $(\'.slider-modal .wrapper\').on(\'click\', function(event) {
            closeSliderModal();
        });
        $(\'.slider-modal img\').on(\'click\', function(event) {
            event.stopPropagation();
        });
        $(\'.slider-modal .close-window\').on(\'click\', function(event) {
            closeSliderModal();
        });

        $(document).keyup(function(event){
            if (event.which == 27) {
                closeSliderModal();
            } 
        });
        $(\'.building .slider-list\').on(\'click\', \'.slider-item\', function(event) {
            let slideIndex = $(this).attr(\'data-index\');
            showGalleryModal(slideIndex, curSlider = \'building\');
        });
        $(\'.building .slider-modal button\').on(\'click\', function(event) {
            let action = $(this).attr(\'data-action\');
            let curIndex = $(this).parent(\'.slider-modal\').find(\'.wrapper img\').attr(\'data-index\');
            changeGallerySlider(action, curIndex, curSlider = \'building\');
        });

        function closeSliderModal(event) {
            $(\'.slider-modal\').fadeOut();
            $(\'.slider-modal .wrapper\').html("");
        }
        function showGalleryModal(slideIndex, curSlider) {
            let imgSrc;
            imgSrc = $(\'.building .slider-list .slider-item[data-index=\'+slideIndex+\'] .slider-bg\').css(\'backgroundImage\');
            imgSrc = imgSrc.split(\'"\')[1];
            $(\'.building .slider-modal .wrapper\').html("").append("<img src=\'"+imgSrc+"\' data-index="+slideIndex+">");
            $(\'.building .slider-modal\').fadeIn(400);
            setTimeout(function(){
                $(\'.building .slider-modal .wrapper\').fadeIn(200).css(\'left\',\'0\');
            }, 300);
        }
        function changeGallerySlider(action, curIndex, curSlider) {
            let prevIndex;
            let nextIndex;
            let slideCount = 0;
            let lastIndex;
 
            $(\'.building .slider-list .slick-slide\').each(function() {
                if (!$(this).hasClass(\'slick-cloned\')) {
                    $(this).find(\'.slider-item\').each(function(){
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

            if (action == \'Prev\') {
                setTimeout(function(){
                    $(\'.building .slider-modal .wrapper\').css(\'left\',\'-110%\');
                }, 200);
                setTimeout(function(){
                    $(\'.building .slider-modal .wrapper\').hide().css(\'left\',\'110%\');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(prevIndex, curSlider = \'building\');
                }, 350);  
            } else if (action == \'Next\') {
                setTimeout(function(){
                    $(\'.building .slider-modal .wrapper\').css(\'left\',\'110%\');
                }, 200);
                setTimeout(function(){
                    $(\'.building .slider-modal .wrapper\').hide().css(\'left\',\'-110%\');
                }, 300);
                setTimeout(function(){
                    showGalleryModal(nextIndex, curSlider = \'building\');
                }, 350);  
            }
        }
        function setSliderIndex() {
            let indexBuilding = 0;
            $(\'.building .slider-list .slick-slide\').each(function() {
                if (!$(this).hasClass(\'slick-cloned\')) {
                    $(this).find(\'.slider-item\').each(function(){
                        $(this).attr(\'data-index\', indexBuilding);
                        indexBuilding++;
                    });          
                }
            });    
        }
        function initBuildingSlider($slick_container){
            $slick_container.removeClass(\'slick-initialized slick-slider\');
            $slick_container.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
            });
        }
        initBuildingSlider($(\'.building .slider-list\'));

        $(\'.building .date-list .date-item\').click(function(event) {
            let sliderID = $(this).attr(\'data-id\');
            let templateFolder = "/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/news.list/building";
            $(\'.building .date-list .date-item\').removeClass(\'active\');
            $(this).addClass(\'active\');
            $.ajax({
               url: templateFolder+\'/slider-items.ajax.php\',
               type: \'POST\',
               dataType: \'json\',
               data: {SLIDER_ID: sliderID},
            })
            .done(function(ajaxResult) {
                $(\'.building .slider-list\').fadeOut(\'fast\').html(ajaxResult.HTML).fadeIn(\'slow\');
                initBuildingSlider($(\'.building .slider-list\'));
                setSliderIndex();
            });
        });
    });
</script>";s:4:"VARS";a:2:{s:8:"arResult";a:7:{s:2:"ID";s:1:"9";s:14:"IBLOCK_TYPE_ID";s:19:"atwebsite_novostroy";s:13:"LIST_PAGE_URL";N;s:15:"NAV_CACHED_DATA";N;s:4:"NAME";s:33:"Ход строительства";s:7:"SECTION";b:0;s:8:"ELEMENTS";a:2:{i:0;i:36;i:1;i:42;}}s:18:"templateCachedData";a:4:{s:13:"additionalCSS";s:85:"/bitrix/templates/atwebsite_stroy_tmpl/components/bitrix/news.list/building/style.css";s:9:"frameMode";b:1;s:17:"__currentCounters";a:1:{s:28:"bitrix:system.pagenavigation";i:1;}s:13:"__editButtons";a:4:{i:0;a:5:{i:0;s:13:"AddEditAction";i:1;s:2:"36";i:2;s:210:"/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=9&type=atwebsite_novostroy&ID=36&lang=ru&force_catalog=&filter_section=0&bxpublic=Y&from_module=iblock&return_url=%2F%3Fbitrix_include_areas%3DY%26clear_cache%3DY";i:3;s:31:"Изменить элемент";i:4;a:0:{}}i:1;a:5:{i:0;s:15:"AddDeleteAction";i:1;s:2:"36";i:2;s:163:"/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=9&type=atwebsite_novostroy&lang=ru&action=delete&ID=36&return_url=%2F%3Fbitrix_include_areas%3DY%26clear_cache%3DY";i:3;s:29:"Удалить элемент";i:4;a:1:{s:7:"CONFIRM";s:123:"Будет удалена вся информация, связанная с этой записью. Продолжить?";}}i:2;a:5:{i:0;s:13:"AddEditAction";i:1;s:2:"42";i:2;s:210:"/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=9&type=atwebsite_novostroy&ID=42&lang=ru&force_catalog=&filter_section=0&bxpublic=Y&from_module=iblock&return_url=%2F%3Fbitrix_include_areas%3DY%26clear_cache%3DY";i:3;s:31:"Изменить элемент";i:4;a:0:{}}i:3;a:5:{i:0;s:15:"AddDeleteAction";i:1;s:2:"42";i:2;s:163:"/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=9&type=atwebsite_novostroy&lang=ru&action=delete&ID=42&return_url=%2F%3Fbitrix_include_areas%3DY%26clear_cache%3DY";i:3;s:29:"Удалить элемент";i:4;a:1:{s:7:"CONFIRM";s:123:"Будет удалена вся информация, связанная с этой записью. Продолжить?";}}}}}}';
return true;
?>