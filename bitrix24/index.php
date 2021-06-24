<?
define("PUBLIC_AJAX_MODE", true);
define('STOP_STATISTICS', true);
define('MODULE_ID', 'atwebsite.novostroy');

// include bitrix core
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
use Bitrix\Main\Web\Json;

$request = Context::getCurrent()->getRequest();
$postParams = $request->getPostList(); 

if ($postParams->get('event') !== 'ONCRMDEALUPDATE') { 
    if (!$request->isPost()) { 
        LocalRedirect(SITE_DIR);
    }

    // VALIDATE
    if ($_SERVER['HTTP_HOST'] && $_SERVER['SERVER_NAME'] && $_SERVER['HTTP_HOST'] != $_SERVER['SERVER_NAME']) {
        echo Json::encode(['error' => 'ERROR_ACCESS_DENIED']);
        die();
    }
    
    try {
        $data = Json::decode($request->getInput());
    } catch (\Exception $e) {
        $data = $postParams;
    }

    if (empty($data['params'])) {
        echo Json::encode(['error' => 'ERROR_EMPTY_PARAMS']);
        die();
    }

    if (!$data['action'] || !function_exists($data['action'])) {
        echo Json::encode(['error' => 'ERROR_ACTION_NOT_FOUND']);
        die();
    }
} else {
    $authCode = COption::GetOptionString(MODULE_ID, 'auth_code', '', SITE_ID);
    $portal   = COption::GetOptionString(MODULE_ID, 'address', '', SITE_ID);
    $userId   = COption::GetOptionString(MODULE_ID, 'user_id', '', SITE_ID);
    $webhook  = COption::GetOptionString(MODULE_ID, 'webhook', '', SITE_ID);
    $auth = $postParams->get('auth');
    $eventData = $postParams->get('data');
    
    $data['action'] = 'handleWebhook';
    $data['params'] = [
        'id' => $eventData['FIELDS']['ID'], 
        'portal' => $portal, 
        'userId' => $userId,
        'webhook' => $webhook
    ];
   
    if ($authCode != $auth['application_token']) { die(); }
}

// RUN
$result = $data['action']($data['params']);
echo Json::encode($result);
die();


// ACTIONS 

function connect($params) {
    $portal = $params['portal'];
    
    if (gethostbyname($portal) === $portal) {
        return ['error' => 'ERROR_SITE_NOT_FOUND'];
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://'.$portal.'/rest/'.$params['userId'].'/'.$params['webhook'].'/profile/');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseJson = curl_exec($ch);
    curl_close($ch);
    
    if (!$responseJson) {
        return ['error' => 'ERROR_CONNECT_SITE'];
    }
    
    $response = Json::decode($responseJson);
    
    if ($response['error'] && $response['error'] == "INVALID_CREDENTIALS") {
        return ['error' => 'ERROR_INVALID_CREDENTIALS'];
    }
    
    $result = COption::SetOptionString(MODULE_ID, 'connect', 'Y', false, $params['siteId']);
    
    if (!$result) {
        return ['error' => 'ERROR_SAVE_CONNECT'];
    }
    
    return ['success' => true];
}


function disconnect($params) {
    $result = COption::SetOptionString(MODULE_ID, 'connect', 'N', false, $params['siteId']);
    
    if (!$result) {
        return ['error' => 'ERROR_SAVE_CONNECT'];
    }
    
    return ['success' => true];
}


function handleWebhook($params) {
    CModule::IncludeModule('iblock');
    
    $connect = COption::GetOptionString(MODULE_ID, 'connect', 'N', SITE_ID);
    $order   = COption::GetOptionString(MODULE_ID, 'order', '', SITE_ID);
    
    if ($order != 'status' || $connect != 'Y') { return; }
    
    $url = 'http://'.$params['portal'].'/rest/'.$params['userId'].'/'.$params['webhook'].'/';
    
    #get deal
    $requestParams = ['id' => $params['id']];
    $response = curlGet($url, 'crm.deal.get', $requestParams);
    
    # get iblock section id
    $regExp = '/\[(\d*)\]/m';
    preg_match($regExp, $response['result']['TITLE'], $matches); 
    $sectionId = $matches[1];
    
    # check deal stage && section id exist
    if (!$sectionId || empty($response['result']) || $response['result']['ORIGINATOR_ID'] != MODULE_ID) {
        die();
    }
    
    # stage list for cancel
    $skipStageList = ['NEW', 'WON', 'LOSE', 'APOLOGY']; 
    
    # get deals for current section id
    $requestParams = [
        'filter' => [
            'ORIGINATOR_ID' => MODULE_ID,
            '%TITLE' => '['.$sectionId.']'
        ]
    ]; 
    $response = curlGet($url, 'crm.deal.list', $requestParams);
    if (empty($response['result'])) { die(); }
    
    $stageList = array_column($response['result'], 'STAGE_ID');
    
    $status = 'STROY_FREE';  
    foreach ($stageList as $stage) {
        if (!in_array($stage, $skipStageList)) {
            $status = 'STROY_ORDER';
            break;
        }
    }
    
    // get iblock
    $res = CIBlock::GetList([], ['CODE' => 'catalog_no_floor', 'TYPE' => 'atwebsite_novostroy']);
    $iblock = $res->Fetch();
    
    // get property UF_STATUS
    $res = CUserTypeEntity::GetList(['id' => 'asc'], [
        'ENTITY_ID' => 'IBLOCK_'.$iblock['ID'].'_SECTION',
        'FIELD_NAME' => 'UF_STATUS'
    ]);
    $propStatus = $res->Fetch();
    
    # get UF_STATUS value order
    $res = CUserFieldEnum::GetList(['id' => 'asc'], [
        'USER_FIELD_ID' => $propStatus['ID'],
        'XML_ID' => $status
    ]);
    $propStatusOrder = $res->Fetch();
   
    # update status
    $nsection = new CIBlockSection;
    $res = $nsection->Update($sectionId, ['UF_STATUS' => $propStatusOrder['ID']]);
        
    die();
}


function changeStatus($params) {
    CModule::IncludeModule('iblock');
    
    $nsection = new CIBlockSection;
    $result = $nsection->Update($params['sectionId'], ['UF_STATUS' => $params['statusId']]);

    return ['success' => $result];
}


function curlGet($url, $action, $params = []) {
    $ch = curl_init($url.$action.'/?'.http_build_query($params)); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $responseJson = curl_exec($ch);
    
    $response = \Bitrix\Main\Web\Json::decode($responseJson);
    
    curl_close($ch);
    
    return $response;
}
?>