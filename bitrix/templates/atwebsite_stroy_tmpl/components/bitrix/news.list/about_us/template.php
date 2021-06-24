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

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<section id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="about-us" style="background:linear-gradient(to top right, #211c50, #5ec2af);">
<div class="container row">
	<div class="left-side col-12 col-md-6 p-0" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>');"></div>
	<div class="right-side col-12 col-md-6 p-0">
        <h3 class="content-title"><?=$arItem["NAME"]?></h3>
        <div class="content-wrapper">
            <div class="content-text">
                <?=$arItem["PREVIEW_TEXT"]?>
            </div>
            <?if ($arItem['PROPERTIES']['BUTTON_LINK']['VALUE']):?>
            <div class="content-button">
                <a href="#anc_building" target=_blank download><?=$arItem["PROPERTIES"]["BUTTON_TITLE"]["VALUE"]?></a>
            </div>
<?endif;?>
        </div>
    </div>
</div>
</section>
<?endforeach;?>

