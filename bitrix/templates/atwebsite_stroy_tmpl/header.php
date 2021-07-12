<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Page\Asset;

IncludeTemplateLangFile(__FILE__);
CJSCore::Init(array("fx", "ajax"));

$asset = Asset::getInstance();
$curPage = $APPLICATION->GetCurPage();

const INC_FILE_PATH = SITE_TEMPLATE_PATH.'/include';
?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID;?>-<?=strtoupper(LANGUAGE_ID);?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?$APPLICATION->ShowTitle();?></title>
    <?$APPLICATION->ShowHead();?>
    <?$asset->AddString('<link rel="shortcut icon" type="image/x-icon" href="'.SITE_TEMPLATE_PATH.'/images/favicon.ico">');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/reset.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/bootstrap.min.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/font-awesome.min.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/slick.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/animate.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/addons.css');?>
    <?$asset->AddCSS(SITE_TEMPLATE_PATH.'/css/jquery.plugins.css');?>
    <?$asset->AddString('<link rel="stylesheet" href="'.SITE_TEMPLATE_PATH.'/css/themes/theme-params.css?'.rand(1, 9999).'">');?>
    <!--[if lte IE 7]><link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/ie.css"><![endif]-->
    <?$asset->AddJs(SITE_TEMPLATE_PATH.'/js/jquery.min.js');?>
    <script>
        BX.message({
            TEMPLATE_PATH: "<?=SITE_TEMPLATE_PATH?>"
        });
    </script>
    <meta property = "og:image" content = "<?=SITE_TEMPLATE_PATH?>/images/favicon.ico">
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <div class="popup-form-call callback-form">
    <?$APPLICATION->IncludeComponent(
    	"bitrix:form.result.new",
    	"callback-form",
    	array(
    		"CACHE_TIME" => "3600",
    		"CACHE_TYPE" => "A",
    		"CHAIN_ITEM_LINK" => "",
    		"CHAIN_ITEM_TEXT" => "",
    		"COMPONENT_TEMPLATE" => "callback-form",
    		"EDIT_URL" => "",
    		"IGNORE_CUSTOM_TEMPLATE" => "N",
    		"LIST_URL" => "",
    		"SEF_MODE" => "N",
    		"SUCCESS_URL" => "#",
    		"USE_EXTENDED_ERRORS" => "Y",
    		"WEB_FORM_ID" => "1",
    		"VARIABLE_ALIASES" => array(
    			"WEB_FORM_ID" => "WEB_FORM_ID",
    			"RESULT_ID" => "RESULT_ID",
    		)
    	),
    	false
    );?>
    </div>
    <a name="top"></a>
    <header class="<?if($APPLICATION->GetCurPage(false) != SITE_DIR) { echo 'inner-page';}?>">

        <div class="header__top-line container row align-items-center justify-content-between">


            <div class="header-menu">
                <?=file_get_contents($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/images/icons/burger-menu.svg")?>
            </div>
            <div class="header-logo"><a href="<?=SITE_DIR?>">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH.'/inc_header-logo.php')
                );?>
            </a></div>
            <div class="smenu">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "main-menu2",
                    Array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "left",
                        "USE_EXT" => "N"
                    )
                );?>
            </div>
            <div class="header-text">
                <span><?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_header-address.php")
                );?></span>
                <a class="show-on-map d-block" href="#anc_contacts">
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_header-show_on_map.php")
                );?></a>
            </div>
            <div class="header-phone">
                <a href="" class="tel">
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_header-phone.php")
                );?></a>
                <div class="header-button">
                    <a class="call-link" href="">
                        <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_header-call_btn.php")
                );?></a>
                </div>
            </div>
        </div>
        <div class="main-menu">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "main-menu",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top",
                    "USE_EXT" => "N"
                )
            );?>
        </div>
    </header>
    <main>