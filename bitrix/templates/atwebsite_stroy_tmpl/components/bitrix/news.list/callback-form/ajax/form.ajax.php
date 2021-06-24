<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

\Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

$arData = [];
$arAnswer = [];

$MESS['err_empty_value']   = 'err_empty_value';
$MESS['err_value_name']    = 'err_value_name';
$MESS['err_value_phone']   = 'err_value_phone';
$MESS['err_value_email']   = 'err_value_email';
$MESS['err_value_message'] = 'err_value_message';
$MESS['result_ok'] = 'result_ok';
$MESS['result_err'] = 'result_err';

if($_POST) {
	$arData['post'] = $_POST;
	foreach($_POST['DATA_FORM'] as $arItem) {
		switch ($arItem['name']) {
			case 'name':
				if($arItem['value'] == "") {
					$arData['error'][] = 'err_empty_value';
				} elseif (!preg_match("/^[a-zA-Z".Loc::getMessage("REG_CYR_INTERVAL")."\s\-]+$/",iconv('utf-8', 'windows-1251', $arItem['value'])) || iconv_strlen($arItem['value']) < 2 || iconv_strlen($arItem['value']) > 80) {
					$arData['error'][] = 'err_value_name';
				} else {
					$arData[$arItem['name']] = $arItem['value'];
				}
				break;

			case 'phone':
				if($arItem['value'] == "") {
					$arData['error'][] = 'err_empty_value';
				} elseif (!preg_match("/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/", $arItem['value'])) {
					$arData['error'][] = 'err_value_phone';
				} else {
					$arData[$arItem['name']] = $arItem['value'];
				}
				break;
			case 'email':
				if ($arItem['value'] == "") {
					$arData[$arItem['name']] = $arItem['value'];
				} elseif (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,4}$/", $arItem['value'])) {
					$arData['error'][] = 'err_value_email';
				} else {
					$arData[$arItem['name']] = $arItem['value'];
				}
				break;
			case 'message':
				if(iconv_strlen($arItem['value']) > 450) {
					$arData['error'][] = 'err_value_message';
				} else {
					$arData[$arItem['name']] = $arItem['value'];
				}
				break;
		}		
	}

	$messName = $_POST['FORM_TYPE'] == 'CALL'? $_POST['MESS_CALLBACK']: $_POST['MESS_ORDER'];
	$detailInfo = $_POST['FORM_TYPE'] == 'ORDER'? $_POST['DETAIL_INFO']: '';
	$iblockID = intval($_POST['IBLOCK_ID']);
	$postType = $_POST['POST_TYPE'];
	$postID = intval($_POST['POST_ID']);
	
		if($arData['error']) {
			$arAnswer['result_err'] = $arData['error'];
		} else {
			$el = new CIBlockElement;
			$PROP = array();
			$PROP['NAME'] = $arData['name'];
			$PROP['PHONE'] = $arData['phone'];
			$PROP['EMAIL'] = $arData['email'];
			$arLoadElement = Array(
				"IBLOCK_ID" 	  => $iblockID,
				"ACTIVE"          => "N",
				"NAME"            => $messName,
				"PROPERTY_VALUES" => $PROP,
				"PREVIEW_TEXT"    => $arData['message'],
				"DETAIL_TEXT"     => $detailInfo
			);

			if($ELEMENT_ID = $el->Add($arLoadElement)) {
				$arEventFields = array(
				    "CALL_TYPE" => $messName,
				    "NAME"      => $arData["name"],
				    "PHONE"     => $arData["phone"],
				    "EMAIL"     => $arData["email"],
				    "MESSAGE"   => $arData["message"],
				    "DETAIL"    => $detailInfo
				);
				CEvent::Send($postType, SITE_ID, $arEventFields, $postID);
				$arAnswer['result_ok'] = $MESS['result_ok'];
			} else {
				$arAnswer['result_err'] = $MESS['result_err'];
			}	
			
		}

	
} else {
	$arAnswer['result_err'] = $MESS['result_err'];
}

echo json_encode($arAnswer, JSON_UNESCAPED_UNICODE);
?>