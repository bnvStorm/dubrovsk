<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
if ($_POST['ITEM_ID']) {    
    if (CModule::IncludeModule("iblock")) {
       
        $itemID = $_POST['ITEM_ID'];
        $res = CIBlockElement::GetByID($itemID);
        $arItem = $res->Fetch();
        $resProp = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], array(), array());
        while ($arProp = $resProp->GetNext()) {
            switch ($arProp['CODE']) {
                case 'SHOW_BUTTON':
                    $showButton = empty($arProp['VALUE'])? false: true;
                    break;
                case 'SHOW_TIMER':
                   $showTimer = empty($arProp['VALUE'])? false: true;
                    break;
            }
        }
        $arrDate = explode(' ', $arItem['ACTIVE_TO']);
        $strTime = $arrDate[1];
        $strDay = explode('.', $arrDate[0])[0];
        $strMounth = explode('.', $arrDate[0])[1];
        $strYear = explode('.', $arrDate[0])[2];
        $mounthName = date("F",mktime(0,0,0,$strMounth,$strDay,$strYear));
        if ($showTimer) {
            $ajaxResult['showTimer'] = 'YES';
            $ajaxResult['endDate'] = $mounthName.' '.$strDay.', '.$strYear.' '.$strTime;
        } else {
            $ajaxResult['showTimer'] = 'NO';
        }
        if ($showButton) {
            $ajaxResult['showButton'] = 'YES';
        } else {
            $ajaxResult['showButton'] = 'NO';
        }
        $ajaxResult['bgImage'] = CFile::GetPath($arItem['PREVIEW_PICTURE']);
        $ajaxResult['contentTitle'] = $arItem["PREVIEW_TEXT"];
        $ajaxResult['contentText'] = $arItem["DETAIL_TEXT"];
    
        if (SITE_CHARSET == 'windows-1251') {
            $ajaxResult['contentTitle'] = iconv(SITE_CHARSET, 'utf-8', $ajaxResult['contentTitle']);
            $ajaxResult['contentText'] = iconv(SITE_CHARSET, 'utf-8', $ajaxResult['contentText']);
        }
    }
}
echo json_encode($ajaxResult);
?>