<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if ($_POST) {
    $ajaxResult['POST'] = $_POST;
    if(CModule::IncludeModule("iblock")) {
        $bs = new CIBlockSection;
        if ($_POST['AREAS']) {
            foreach ($_POST['AREAS'] as $area) {
                if (empty($area['ID'])) {
                    $arFields = array(
                        "ACTIVE"            => "Y",
                        "IBLOCK_ID"         => $_POST['IBLOCK_ID'],
                        "IBLOCK_SECTION_ID" => $_POST['SECTION_ID'],
                        'WIDTH'             => $_POST['UF_BLOCK_WIDTH'],
                        "NAME"              => $area['NAME'],
                        "UF_POINTS"         => $area['POINTS'],
                        'UF_AREA_TITLE'     => $_POST['UF_AREA_TITLE'],
                    );
                    $actionResult = $bs->Add($arFields);
                } else {
                    $actionResult = $bs->Update($area['ID'], array("UF_POINTS" => $area['POINTS']));
                }
            }
            if (!empty($_POST['UF_BLOCK_WIDTH'])) {
                $actionResult = $bs->Update($_POST['SECTION_ID'], array("UF_BLOCK_WIDTH" => $_POST['UF_BLOCK_WIDTH']));
            }
        } elseif ($_POST['ACTION_EDIT_AREA'] == 'Y' && !empty($_POST['SECTION_ID'])) {
            $arFields = array(
                "NAME" => $_POST['NEW_AREA_NAME'],
            );
            $arKeys = [
                "UF_AREA_COLOR",
                "UF_AREA_TITLE"
            ];
            foreach ($arKeys as $key) {
                if (!empty($_POST[$key]) && $_POST[$key] != undefined) {
                    $arFields[$key] = $_POST[$key];
                }
            }
            $actionResult = $bs->Update($_POST['SECTION_ID'], $arFields);
        } elseif ($_POST['ACTION_DELETE_AREA'] == 'Y' && !empty($_POST['SECTION_ID'])) {
            $deleteResult = $bs->Delete($_POST['SECTION_ID']);
        }
    }
    if ($actionResult || $deleteResult) {
        $ajaxResult['success'] = 'Y';
        $ajaxResult['message'] = 'Изменения сохранены';
    } else {
        $ajaxResult['success'] = 'N';
        $ajaxResult['message'] = 'Не удалось сохранить изменения.';
    }
} else {
    $ajaxResult['message'] = 'Пожалуйста, завершите выделение областей. Изменения не сохранены.';
}

if (SITE_CHARSET == 'windows-1251') {
    $ajaxResult['message'] = iconv(SITE_CHARSET, 'utf-8', $ajaxResult['message']);
}

echo json_encode($ajaxResult);