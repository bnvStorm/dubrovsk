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
<div class="slider-list">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="slider-item text-center">
        <div class="slider-bg" style="background-image:url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>);"></div>
        <div class="wrapper">
            <div class="picture">
                <img src="<?=$arItem['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC']?>" alt="">
            </div>
            <p class="preview-text">
                <?=$arItem["PREVIEW_TEXT"]?>
            </p>
            <div class="descr">
                <p class="descr-text">
                    <?=$arItem["DETAIL_TEXT"]?>
                </p>
            </div>
        </div>
    </div>   
<?endforeach;?>      
</div>