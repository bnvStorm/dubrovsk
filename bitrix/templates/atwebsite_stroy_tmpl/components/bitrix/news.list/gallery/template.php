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
    <div id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="slider-group">
        <?
        $arImgSrc = [];
        foreach ($arItem['PROPERTIES']['PICTURES']['VALUE'] as $picID) {
            $arImgSrc[] = CFile::GetPath($picID);
        }?>
        <div class="row-1 row">         
            <?if ($arImgSrc[0]):?><div class="slider-item col-12 col-md-6">
                <div class="slider-bg" style="background-image: url('<?=$arImgSrc[0]?>')"></div>
            </div><?endif;?>
            <?if ($arImgSrc[1]):?><div class="slider-item col-12 col-md-6">
                <div class="slider-bg" style="background-image: url('<?=$arImgSrc[1]?>')"></div>
            </div><?endif;?>
        </div>
        <div class="row-2 row">
            <?if ($arImgSrc[2]):?><div class="slider-item col-12 col-md-4">
                <div class="slider-bg" style="background-image: url('<?=$arImgSrc[2]?>')"></div>
            </div><?endif;?>
            <?if ($arImgSrc[3]):?><div class="slider-item col-12 col-md-4">
                <div class="slider-bg" style="background-image: url('<?=$arImgSrc[3]?>')"></div>
            </div><?endif;?> 
            <?if ($arImgSrc[4]):?><div class="slider-item col-12 col-md-4">
                <div class="slider-bg" style="background-image: url('<?=$arImgSrc[4]?>')"></div>
            </div><?endif;?>
        </div>
    </div>
    <?endforeach;?> 
</div>
<div class="slider-modal">
    <span class="close-window"></span>
    <button class="slide-prev slide-arrow" data-action="Prev" type="button" style="">Prev</button>
    <div class="wrapper"></div>
    <button class="slide-next slide-arrow" data-action="Next" type="button" style="">Next</button>
</div>