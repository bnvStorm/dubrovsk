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

$svgIconList = [
    'pdf' => file_get_contents($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/pdf-icon.svg'),
    'word' => file_get_contents($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/word-icon.svg'),
    'excel' => file_get_contents($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/excel-icon.svg')
];
?>
<div class="doc-list row align-items-center">
    <?foreach($arResult["ITEMS"] as $index => $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    $fileSrc = $arItem['DISPLAY_PROPERTIES']['FILE']['FILE_VALUE']['SRC'];
    $fileName = end(explode("/", $fileSrc));
    $fileExt = end(explode(".", $fileName));
    switch ($fileExt) {
        case 'pdf':
            $icon = $svgIconList['pdf'];
            break;  
        case 'doc':
        case 'docx':
            $icon = $svgIconList['word'];
            break; 
        case 'xls':
        case 'xlsx':
            $icon = $svgIconList['excel'];
            break; 
        default:
            $icon = $svgIconList['pdf'];
            break;
    }
    ?>
    <div id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="doc-item col-12 col-md-6 col-lg-3 <?if ($index > 7) echo 'd-none';?>">
        <a href="<?=$fileSrc?>" download class="file-src"></a>
        <?=$icon?><span class="file-name"><?=$arItem['NAME']?></span>
    </div>
    <?endforeach;?>
</div>
<?if(count($arResult["ITEMS"]) > 8):?>
<a class="show-more" href=""><?=GetMessage('SHOW_MORE')?></a>
<?endif;?>