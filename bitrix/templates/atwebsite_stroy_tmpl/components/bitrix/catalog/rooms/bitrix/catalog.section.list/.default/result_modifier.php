<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Application, 
    Bitrix\Main\Context, 
    Bitrix\Main\Request, 
    Bitrix\Main\Server;
	
Bitrix\Main\Loader::includeModule('iblock');
CModule::IncludeModule('iblock');
	
$context = Context::getCurrent();
$request = $context->getRequest();

//echo "<pre>"; print_r($request); echo "</pre>";

$arStatusClass = ["STROY_FREE" => "free", "STROY_ORDER" => "order", "STROY_SELL" => "sell"];

$sectID = ($request["id"] ? intval($request["id"]) : 0);

$arResult["UF_FIELDS"]=[];
$rsData = CUserTypeEntity::GetList(["XML_ID"=>"ASC", "SORT"=>"ASC"], ["ENTITY_ID"=>"IBLOCK_".$arParams["IBLOCK_ID"]."_SECTION", "LANG"=>"ru"]);
while($arRes = $rsData->Fetch())
{
	if(!$arRes["XML_ID"]) continue;
    $xmlCategory = explode('---', $arRes["XML_ID"])[0];
	$arResult["UF_FIELDS"][$xmlCategory][$arRes["FIELD_NAME"]] = $arRes;
}

$arResult['DEFAULT_STATUS_CLASS'] = "free";

// get property UF_STATUS
$res = CUserTypeEntity::GetList(['id' => 'asc'], [
    'ENTITY_ID' => 'IBLOCK_'.$arParams["IBLOCK_ID"].'_SECTION',
    'FIELD_NAME' => 'UF_STATUS'
]);
$propStatus = $res->Fetch();

# get UF_STATUS value order
$res = CUserFieldEnum::GetList(['id' => 'asc'], [
    'USER_FIELD_ID' => $propStatus['ID'],
]);
$statusList = [];
while ($propStatusValue = $res->Fetch()) {
	$statusList[$propStatusValue['ID']] = $propStatusValue;
}
$arResult["STATUS_LIST"] = $statusList;

$arResultCustom = []; $keyNew = 0;
$arResult['SECTION'] = [];
foreach ($arResult['SECTIONS'] as $key => $arSection){
	
	if($arSection["DEPTH_LEVEL"] < 3) continue;
	
	$arResultCustom[$keyNew] = $arSection;
	
	$arFilter = array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ID'=>$arSection["ID"], 'ACTIVE' => 'Y');
	$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter, false, ['UF_*']);
	if ($arSect = $rsSections->Fetch())
	{
		$arResultCustom[$keyNew] = array_merge($arSect, $arResultCustom[$keyNew]);
		$arResultCustom[$keyNew]['STATUS_ID'] = $arSect["UF_STATUS"];
        $arResultCustom[$keyNew]['STATUS_NAME'] = $statusList[$arSect["UF_STATUS"]]["VALUE"];
        $arResultCustom[$keyNew]['STATUS_CLASS'] = $arStatusClass[$statusList[$arSect["UF_STATUS"]]["XML_ID"]];
            
		$arResultCustom[$keyNew]['MORE_PHOTO'] = $arSect["UF_MORE_PHOTO"];
		$res = CIBlockSection::GetByID($arSect["IBLOCK_SECTION_ID"]);
		$arResultCustom[$keyNew]['IBLOCK_SECTION_INFO'] = $res->GetNext();
	}
	
	if($sectID && $arSection["ID"] == $sectID){
		$arResult['SECTION'] = $arResultCustom[$keyNew];
	}
	
	$keyNew++;
}

$arResult['SECTIONS'] = $arResultCustom;

//echo "<pre>"; print_r($arResult['SECTIONS']); echo "</pre>";

if(empty($arResult['SECTION'])){
	$arResult['SECTION'] = $arResult['SECTIONS'][0];
}

?>