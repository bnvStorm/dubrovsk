<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResTemp = [];
foreach ($arResult['ITEMS'] as $key => $arItem) {
    if (CModule::IncludeModule("iblock")) {
        $res = CIBlockElement::GetByID($arItem['ID']);
        $arRes = $res->Fetch();
        $detailPic = CFile::GetPath($arRes['DETAIL_PICTURE']);
        $arResTemp[$key] = $arItem;
        $arResTemp[$key]['DETAIL_PICTURE']['ID'] = $arRes['DETAIL_PICTURE'];
        $arResTemp[$key]['DETAIL_PICTURE']['SRC'] = $detailPic;
    }
}
$arResult['ITEMS'] = $arResTemp;
?>