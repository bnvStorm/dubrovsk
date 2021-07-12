<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) {
    ShowMessage(GetMessage("MESS_IBLOCK_ERROR"));
    return false;
}

// get iblock-type list 
$dbIBlockTypes = CIBlockType::GetList(array("SORT"=>"ASC"), array("ACTIVE"=>"Y"));
while ($arIBlockTypes = $dbIBlockTypes->GetNext()) {
    $paramIBlockTypes[$arIBlockTypes["ID"]] = $arIBlockTypes["ID"];
}

//get iblocks list
$dbIBlocks = CIBlock::GetList(
    array("SORT" => "ASC"),
    array("ACTIVE" => "Y", "TYPE" => $arCurrentValues["IBLOCK_TYPE"])
);

while ($arIBlocks = $dbIBlocks->GetNext()) {
    $paramIBlocks[$arIBlocks["ID"]] = "[" . $arIBlocks["ID"] . "] " . $arIBlocks["NAME"];
}

// get sections list
$arSectionsFilter = array(
    'IBLOCK_ID' => $arCurrentValues["IBLOCK_ID"],
    'SECTION_ID' => false
);
if ($arCurrentValues['SHOW_ACTIVE'] == 'Y') {
    $arSectionsFilter['GLOBAL_ACTIVE'] = 'Y';
}
$dbSections = CIBlockSection::GetList(
    array('SORT'=>'ASC'),
    $arSectionsFilter,
    true,
    array()
);
$defaultSectionId = null;
while ($arSections = $dbSections->GetNext()) {
	if (!$defaultSectionId) { $defaultSectionId = $arSections["ID"]; }
    $paramSections[$arSections["ID"]] = $arSections["~NAME"];
}

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" =>  array(
            "PARENT" =>  "BASE",
            "NAME" =>  GetMessage("AT_PRM_ITEM_IBLOCK_TYPE_ID"),
            "TYPE" =>  "LIST",
            "VALUES" =>  $paramIBlockTypes,
            "REFRESH" =>  "Y",
            "MULTIPLE" =>  "N",
        ),
        "IBLOCK_ID" =>  array(
            "PARENT" =>  "BASE",
            "NAME" =>  GetMessage("AT_PRM_ITEM_IBLOCK_ID"),
            "TYPE" =>  "LIST",
            "VALUES" =>  $paramIBlocks,
            "REFRESH"  =>  "Y",
            "MULTIPLE" =>  "N",
        ),
        "SECTION_ID" =>  array(
            "PARENT" =>  "BASE",
            "NAME" =>  GetMessage("AT_PRM_ITEM_SECTIONS"),
            "TYPE" =>  "LIST",
            "VALUES" =>  $paramSections,
            "REFRESH"  =>  "N",
            "MULTIPLE" =>  "N",
			"DEFAULT"  => $defaultSectionId
        ),
        "SHOW_ACTIVE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("AT_PRM_ITEM_SHOW_ACTIVE"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "AJAX_MODE" => array(),
    )
);