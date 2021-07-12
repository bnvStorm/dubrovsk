<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if ($_POST['SECTION_ID']) {
    if(CModule::IncludeModule("iblock")) {
        $obSection = new CIBlockSection;
        switch ($_POST['EVENT']) {
            case 'delete':
                if($obSection->Delete($_POST['SECTION_ID'])) {
                    $ajaxResult['message'] = 'Удаление успешно';
                    $ajaxResult['success'] = 'Y';
                }
                break;
            case 'update':
                
                break;
            default:
                $imgName = $_FILES['IMAGE']['name'];
                $imgTemp = $_FILES['IMAGE']['tmp_name'];
                $imgSize = $_FILES['IMAGE']['size'];

                $ext = pathinfo($imgName, PATHINFO_EXTENSION);
                $ext = strtolower($ext);

                if ($ext!= 'png' && $ext!= 'jpg' && $ext!= 'gif') {
                    $ajaxResult['message'] = 'Изображение должно быть в формате png, jpg или gif';
                    $ajaxResult['success'] = 'N';
                    exit;
                }

                try {
                    move_uploaded_file($imgTemp, $_SERVER['DOCUMENT_ROOT'].'/upload/'.$imgName);
                    $sectionPicture = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/'.$imgName);

                    if($obSection->Update($_POST['SECTION_ID'], array("PICTURE" => $sectionPicture))) {
                        $ajaxResult['message'] = 'Изображение успешно загружено';
                        $ajaxResult['success'] = 'Y';
                    }
                } catch (Exception $e) {
                    $ajaxResult['message'] = 'Не удалось загрузить изображение';
                    $ajaxResult['success'] = 'N';
                }
                break;
        }
    }    
} else {
    $ajaxResult['message'] = 'Не удалось получить данные';
    $ajaxResult['success'] = 'N';
}

if (SITE_CHARSET == 'windows-1251') {
    $ajaxResult['message'] = iconv(SITE_CHARSET, 'utf-8', $ajaxResult['message']);
}

echo json_encode($ajaxResult);