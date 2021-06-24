<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="date-list">
<?

$arImgSrc = [];
$sliderID = "";
foreach($arResult["ITEMS"] as $index => $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <span 
    id="<?=$this->GetEditAreaID($arItem['ID'])?>" 
    data-id="<?=$arItem['ID']?>" 
    class="date-item <?if($index==count($arResult["ITEMS"])-1) echo "active";?>">
        <?=$arItem['NAME']?>
    </span>
    <?$sliderID = $arItem['ID'];
    foreach ($arItem['PROPERTIES']['PICTURES']['VALUE'] as $picID) {
        $arImgSrc[$arItem['ID']][] = CFile::GetPath($picID);
    }?>
<?endforeach;?>
</div>
<div class="slider-list">
    <?
    $numSlides = ceil(count($arImgSrc[$sliderID])/5); // calculate count of slides
    $strHtml = '';
    
    for ($i = 0; $i < $numSlides; $i++) {
        // searching slider images
        $imgSrc1 = $arImgSrc[$sliderID][$i*5];
        $imgSrc2 = $arImgSrc[$sliderID][$i*5+1];
        $imgSrc3 = $arImgSrc[$sliderID][$i*5+2];
        $imgSrc4 = $arImgSrc[$sliderID][$i*5+3];
        $imgSrc5 = $arImgSrc[$sliderID][$i*5+4];

        $strHtml .= '<div class="slider-group">';
        $strHtml .= '<div class="row-1 row">';
        $strHtml .= '<div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url('.$imgSrc1.')"></div></div>';
        if ($imgSrc2) $strHtml .= '<div class="slider-item col-12 col-md-6"><div class="slider-bg" style="background-image: url('.$imgSrc2.')"></div></div>';
        $strHtml .= '</div>';
        $strHtml .= '<div class="row-2 row">';
        if ($imgSrc3) $strHtml .= '<div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url('.$imgSrc3.')"></div></div>';
        if ($imgSrc4) $strHtml .= '<div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url('.$imgSrc4.')"></div></div>';
        if ($imgSrc5) $strHtml .= '<div class="slider-item col-12 col-md-4"><div class="slider-bg" style="background-image: url('.$imgSrc5.')"></div></div>';
        $strHtml .= '</div>';
        $strHtml .= '</div>';
    }
    echo $strHtml;
    ?>
</div>
<div class="slider-modal">
    <span class="close-window"></span>
    <button class="slide-prev slide-arrow" data-action="Prev" type="button" style="">Prev</button>
    <div class="wrapper"></div>
    <button class="slide-next slide-arrow" data-action="Next" type="button" style="">Next</button>
</div>
<script>
    $(function(){
        $('.slider-modal .wrapper').on('click', function(event) {
            closeSliderModal();
        });
        $('.slider-modal img').on('click', function(event) {
            event.stopPropagation();
        });
        $('.slider-modal .close-window').on('click', function(event) {
            closeSliderModal();
        });

        $(document).keyup(function(event){
            if (event.which == 27) {
                closeSliderModal();
            } 
        });
        $('.building .slider-list').on('click', '.slider-item', function(event) {
            let slideIndex = $(this).attr('data-index');
            showGalleryModal(slideIndex, curSlider = 'building');
        });
        $('.building .slider-modal button').on('click', function(event) {
            let action = $(this).attr('data-action');
            let curIndex = $(this).parent('.slider-modal').find('.wrapper img').attr('data-index');
            changeGallerySlider(action, curIndex, curSlider = 'building');
        });

        function closeSliderModal(event) {
            $('.slider-modal').fadeOut();
            $('.slider-modal .wrapper').html("");
        }
        function showGalleryModal(slideIndex, curSlider) {
            let imgSrc;
            imgSrc = $('.building .slider-list .slider-item[data-index='+slideIndex+'] .slider-bg').css('backgroundImage');
            imgSrc = imgSrc.split('"')[1];
            $('.building .slider-modal .wrapper').html("").append("<img src='"+imgSrc+"' data-index="+slideIndex+">");
            $('.building .slider-modal').fadeIn(400);
            setTimeout(function(){
                $('.building .slider-modal .wrapper').fadeIn(200).css('left','0');
            }, 300);
        }
        function changeGallerySlider(action, curIndex, curSlider) {
            let prevIndex;
            let nextIndex;
            let slideCount = 0;
            let lastIndex;
 
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
        function setSliderIndex() {
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
        function initBuildingSlider($slick_container){
            $slick_container.removeClass('slick-initialized slick-slider');
            $slick_container.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
            });
        }
        initBuildingSlider($('.building .slider-list'));

        $('.building .date-list .date-item').click(function(event) {
            let sliderID = $(this).attr('data-id');
            let templateFolder = "<?=$templateFolder?>";
            $('.building .date-list .date-item').removeClass('active');
            $(this).addClass('active');
            $.ajax({
               url: templateFolder+'/slider-items.ajax.php',
               type: 'POST',
               dataType: 'json',
               data: {SLIDER_ID: sliderID},
            })
            .done(function(ajaxResult) {
                $('.building .slider-list').fadeOut('fast').html(ajaxResult.HTML).fadeIn('slow');
                initBuildingSlider($('.building .slider-list'));
                setSliderIndex();
            });
        });
    });
</script>