<?
//if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
if ($_POST['SLIDER_ID']) {        
    if (CModule::IncludeModule("iblock")) {
        $sliderID = $_POST['SLIDER_ID'];
        $res = CIBlockElement::GetByID($sliderID);
        $arItem = $res->Fetch();
        $resProperty = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], Array("sort" => "asc"), Array("CODE"=>"PICTURES"));
        while($arProperty = $resProperty->GetNext()) {
            $propsList[] = $arProperty['VALUE'];
        }
        foreach ($propsList as $picID) {
            $arImgSrc[] = CFile::GetPath($picID);
        }
        $numSlides = ceil(count($arImgSrc)/5); // calculate count of slides
        $strHtml = '';
        
        for ($i = 0; $i < $numSlides; $i++) {
            // searching slider images
            $imgSrc1 = $arImgSrc[$i*5];
            $imgSrc2 = $arImgSrc[$i*5+1];
            $imgSrc3 = $arImgSrc[$i*5+2];
            $imgSrc4 = $arImgSrc[$i*5+3];
            $imgSrc5 = $arImgSrc[$i*5+4];

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
        $ajaxResult['HTML'] = $strHtml;
    }
}
echo json_encode($ajaxResult);
?>