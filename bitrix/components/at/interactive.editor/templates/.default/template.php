<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CJSCore::Init(array("fx"));
use \Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
$asset->AddJs($templateFolder."/js/colorpicker.js");
$asset->AddCSS($templateFolder."/css/colorpicker.css");
?>
<style>
    .interactive-image polygon.transparent {
        fill: transparent !important;
    }
</style>
<h3 class="content-title wow flash slower blinked-text"><?=GetMessage('MESS_VISUAL_TITLE')?></h3>
<div class="interactive-image" data-id="<?=$arResult['SECTION']['ID']?>" class="wow fadeInRight">
<?if ($arResult['SECTION']):?>
    <?if ($_GET['image_section_id']):?>
    <div class="back-side"><span class="close-page">&#215;</span></div>
    <?endif;?>
    <div class="image-container" data-id="<?=$arResult['SECTION']['ID']?>">
        <img src="<?=$arResult['SECTION']['PICTURE']['SRC']?>" alt="">
        <svg>
            <?foreach ($arResult['SUB_SECTIONS'] as $arSection):?>
            <?$countSubsections = CIBlockSection::GetCount(Array('SECTION_ID' => $arSection['ID']));?>
            <polygon class="transparent" data-id="<?=$arSection['ID']?>" data-count="<?=$countSubsections?>"" points="<?=$arSection['UF_POINTS']?>" title="<?=$arSection['UF_AREA_TITLE']?>"></polygon>
            <?endforeach;?>
            <?if(!$arResult['SUB_SECTIONS']) echo "<polygon></polygon>";?>
        </svg>
        <div class="hover-title"></div>
    </div>
    <div class="area-data">
        <span class="close-window">&#215;</span>
        <div class="content-text"></div>
		<div class="content-text-compute">
            <ul>
                <li class="rooms sum"><?=GetMessage('MESS_ROOMS_ALL')?><span></span></li>
                <li class="rooms free"><?=GetMessage('MESS_ROOMS_FREE')?><span></span></li>
                <li class="rooms sell"><?=GetMessage('MESS_ROOMS_SELL')?><span></span></li>
                <li class="rooms order"><?=GetMessage('MESS_ROOMS_ORDER')?><span></span></li>
                <li class="rooms room_1"><?=GetMessage('MESS_ROOMS_1')?><span></span></li>
                <li class="rooms room_2"><?=GetMessage('MESS_ROOMS_2')?><span></span></li>
                <li class="rooms room_3"><?=GetMessage('MESS_ROOMS_3')?><span></span></li>
                <li class="rooms room_4"><?=GetMessage('MESS_ROOMS_4')?><span></span></li>
                <li class="rooms room_0"><?=GetMessage('MESS_ROOMS_0')?><span></span></li>
            </ul>
        </div>
        <div class="content-button">
            <div class="buttons-block-1" style="text-align:center;">
                <a id="go-to-flat" href="#anc_choose" data-id=""><?=GetMessage('MESS_AREA_LINK')?></a>
            </div>
            <div class="buttons-block-2 d-none"><a href="#anc_choose"><?=GetMessage('MESS_CHOOSE_ROOM')?></a></div>
        </div>
    </div>
<?endif;?>
</div>
<script>
$(function(){
    BX.message(<?= CUtil::PhpToJSObject($arResult['TO_JS_OBJECT'])?>);
    BX.message({
        AJAX_PATH: "<?=$templateFolder.'/ajax'?>",
    });
	$('.interactive-image .image-container polygon').click(function(){
		let areaID = $(this).attr('data-id');
		$('.interactive-image .area-page-link').attr('data-id', areaID);
	});
	if ($('.interactive-image .back-side').length > 0) {
		$('.interactive-image .buttons-block-1').addClass('d-none');
		$('.interactive-image .buttons-block-2').removeClass('d-none');
	} else {
		$('.interactive-image .buttons-block-1').removeClass('d-none');
		$('.interactive-image .buttons-block-2').addClass('d-none');
	}
    $('.interactive-image').on('click', '.area-page-link', function(e){
    	e.preventDefault();
        let itemID = $(this).attr('data-id');
        location.href = '?image_section_id='+itemID+'#anc_visual';
    });
});
</script>