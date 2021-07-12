<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CJSCore::Init(array("fx"));
if (!CModule::IncludeModule("iblock")) die();
if (empty($arParams['SECTION_ID'])) {
    ShowMessage(GetMessage("MESS_SECTION_ERROR"));
    return false;
}

define('SORT_TYPE', array('SORT' => 'ASC', 'ID' => 'ASC'));
$section_id = '';
$ar_result_section = [];
$ar_result_sections_list = [];
$ar_result_subsections = [];
$ar_result_section_tabs = [];

$section_id = $_REQUEST["section_image_id"]? $_REQUEST["section_image_id"]: $arParams['SECTION_ID'];

// GET MAIN SECTION DATA
$ar_section_filter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $section_id);
$q_result_section = CIBlockSection::GetList(SORT_TYPE, $ar_section_filter, true, array('UF_*'));
$ar_result_section = $q_result_section->Fetch();
$ar_result_section['PICTURE'] = ['ID' => $ar_result_section['PICTURE'], 'SRC' => CFile::GetPath($ar_result_section['PICTURE'])];

// GET TREE LIST OF SECTIONS
$ar_tree_list_filter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
if ($arParams['SHOW_ACTIVE'] == 'Y') $ar_tree_list_filter['GLOBAL_ACTIVE'] = 'Y';
$ob_section = CIBlockSection::GetTreeList($ar_tree_list_filter);

while($res_sections_list = $ob_section->GetNext()){
    $ar_result_sections_list[$res_sections_list['ID']] = [
        'ID' => $res_sections_list['ID'],
        'NAME' => $res_sections_list['~NAME'],
        'DEPTH_LEVEL' => $res_sections_list['DEPTH_LEVEL'],
        'IBLOCK_SECTION_ID' => $res_sections_list['IBLOCK_SECTION_ID']
    ];   
}
ksort($ar_result_sections_list);

// GET SECTION TABS
$ar_filter_tabs = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_ID']);
$q_section_tabs = CIBlockSection::GetList(SORT_TYPE, $ar_filter_tabs, true, array());

while ($ar_section_tabs = $q_section_tabs->GetNext()) {
    $ar_result_section_tabs[] = ['ID' => $ar_section_tabs['ID'], 'NAME' => $ar_section_tabs['NAME']];
}

// GET SUBSECTIONS OF MAIN SECTION
$ar_filter_subsections = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $section_id);
if ($arParams['SHOW_ACTIVE'] == 'Y') $ar_filter_subsections['GLOBAL_ACTIVE'] = 'Y';
$q_subsections = CIBlockSection::GetList(SORT_TYPE, $ar_filter_subsections, true, array('UF_*'));

$i = 0;
while($res_subsections = $q_subsections->GetNext()) {
    $ar_result_subsections[$i] = $res_subsections;
    $ar_result_subsections[$i]['PICTURE'] = ['ID' => $res_subsections['PICTURE'], 'SRC' => CFile::GetPath($res_subsections['PICTURE'])];
    $arFilter = Array(
        "IBLOCK_ID"=>$arParams['IBLOCK_ID'],
        "SECTION_ID"=>$res_subsections['ID']
    );

    $sectCount = CIBlockSection::GetCount($arFilter);
    $ar_result_subsections[$i]['ROOM_COUNT'] = $sectCount;

    $query_sect = CIBlockSection::GetList(
        array('ID' => 'ASC'), 
        array('IBLOCK_ID' => $arParams['IBLOCK_ID'], "SECTION_ID"=>$res_subsections['ID']),
        true,
        array('UF_*')
    );

    while($ar_sect = $query_sect->GetNext())
    {
        if ($ar_sect['UF_ROOMS_COUNT'] != "" ) {
            switch ($ar_sect['UF_ROOMS_COUNT']) {
                case '1':
                    $ar_result_subsections[$i]['ROOM_1']++;
                    break;
                case '2':
                    $ar_result_subsections[$i]['ROOM_2']++;
                    break;
                case '3':
                    $ar_result_subsections[$i]['ROOM_3']++;
                    break;
                case '4':
                    $ar_result_subsections[$i]['ROOM_4']++;
                    break;
                default:
                    $ar_result_subsections[$i]['ROOM_0']++;
                    break;
            }
        }   
        if ($ar_sect['UF_STATUS'] == "4" ) {     
            $ar_result_subsections[$i]['ROOM_FREE']++;
        } else if ($ar_sect['UF_STATUS'] == "5") {
            $ar_result_subsections[$i]['ROOM_ORDER']++;
        } else if ($ar_sect['UF_STATUS'] == "6") {
            $ar_result_subsections[$i]['ROOM_SELL']++;
        }
    }
    $i++;
}

// SET FINISH DATA
$arResult['SECTION']       = $ar_result_section;
$arResult['SECTIONS_LIST'] = $ar_result_sections_list;
$arResult['LIST_TABS']     = $ar_result_section_tabs;
$arResult['SUB_SECTIONS']  = $ar_result_subsections;

// SET DATA FOR ACTIONS
$arResult['TO_JS_OBJECT'] = array(
    'IBLOCK_ID'           => $arParams['IBLOCK_ID'],
    'SECTION_ID'          => $section_id,
    'IMG_CONTAINER_WIDTH' => $ar_result_section["UF_BLOCK_WIDTH"],
    'LIST_AREAS'          => $ar_result_subsections,
    'LANG_CHARSET'        => LANG_CHARSET
);

$this->IncludeComponentTemplate();