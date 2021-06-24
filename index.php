<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "ООО «ЛенОблСтрой 47»");
$APPLICATION->SetPageProperty("keywords", "Новостройка");
$APPLICATION->SetPageProperty("description", "Новостройка");
$APPLICATION->SetTitle("ООО «ЛенОблСтрой 47»");
?>
<?// MAIN SLIDER?>
<section class="main-slider">
    <div class="slider-item">
        <div class="item-wrapper container">
            <div class="item-title">
                <h1>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", "",
                        Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_main-slider_title.php")
                    );?>
                </h1>
            </div>
            <hr>
            <div class="item-text">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_main-slider_text.php")
                );?>
            </div>
            <div class="item-button">
                <a class="order-link" href="#anc_choose">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", "",
                        Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_main-slider_btn.php")
                    );?>
                </a>
            </div>
        </div>
        <div class="bg-image">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include", "",
                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_main-slider_bg-image.php")
            );?>
        </div>
    </div>
</section>
<?// CHOOSE ROOM?>
    <a name="anc_choose"></a>
    <section class="choose-room">
        <div class="popup-form-order callback-form">
            <?$APPLICATION->IncludeComponent(
                "bitrix:form.result.new",
                "order-form",
                array(
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "CHAIN_ITEM_LINK" => "",
                    "CHAIN_ITEM_TEXT" => "",
                    "COMPONENT_TEMPLATE" => "order-form",
                    "EDIT_URL" => "",
                    "IGNORE_CUSTOM_TEMPLATE" => "N",
                    "LIST_URL" => "",
                    "SEF_MODE" => "N",
                    "SUCCESS_URL" => "index.php",
                    "USE_EXTENDED_ERRORS" => "Y",
                    "WEB_FORM_ID" => "2",
                    "VARIABLE_ALIASES" => array(
                        "WEB_FORM_ID" => "WEB_FORM_ID",
                        "RESULT_ID" => "RESULT_ID",
                    )
                ),
                false
            );?>
        </div>
        <div class="container">
            <h3 class="content-title">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_content-title_1.php")
                );?>
            </h3>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog",
                "rooms",
                array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_ELEMENT_CHAIN" => "N",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BASKET_URL" => "/personal/basket.php",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "0",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "Y",
                    "DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
                    "DETAIL_BACKGROUND_IMAGE" => "-",
                    "DETAIL_BRAND_USE" => "N",
                    "DETAIL_BROWSER_TITLE" => "-",
                    "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
                    "DETAIL_DETAIL_PICTURE_MODE" => array(
                        0 => "POPUP",
                        1 => "MAGNIFIER",
                    ),
                    "DETAIL_DISPLAY_NAME" => "Y",
                    "DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
                    "DETAIL_IMAGE_RESOLUTION" => "16by9",
                    "DETAIL_META_DESCRIPTION" => "-",
                    "DETAIL_META_KEYWORDS" => "-",
                    "DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
                    "DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
                    "DETAIL_SET_CANONICAL_URL" => "N",
                    "DETAIL_SHOW_POPULAR" => "Y",
                    "DETAIL_SHOW_SLIDER" => "N",
                    "DETAIL_SHOW_VIEWED" => "Y",
                    "DETAIL_STRICT_SECTION_CHECK" => "N",
                    "DETAIL_USE_COMMENTS" => "N",
                    "DETAIL_USE_VOTE_RATING" => "N",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "FILTER_HIDE_ON_MOBILE" => "N",
                    "FILTER_VIEW_MODE" => "VERTICAL",
                    "IBLOCK_ID" => "1",
                    "IBLOCK_TYPE" => "atwebsite_novostroy",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "INSTANT_RELOAD" => "N",
                    "LABEL_PROP" => "",
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "3",
                    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                    "LINK_IBLOCK_ID" => "",
                    "LINK_IBLOCK_TYPE" => "",
                    "LINK_PROPERTY_SID" => "",
                    "LIST_BROWSER_TITLE" => "-",
                    "LIST_ENLARGE_PRODUCT" => "STRICT",
                    "LIST_META_DESCRIPTION" => "-",
                    "LIST_META_KEYWORDS" => "-",
                    "LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "LIST_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                    "LIST_SHOW_SLIDER" => "Y",
                    "LIST_SLIDER_INTERVAL" => "3000",
                    "LIST_SLIDER_PROGRESS" => "N",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => GetMessage("TO_BASKET"),
                    "MESS_BTN_BUY" => GetMessage("BUY"),
                    "MESS_BTN_COMPARE" => GetMessage("COMPARE"),
                    "MESS_BTN_DETAIL" => GetMessage("DETAIL"),
                    "MESS_BTN_SUBSCRIBE" => GetMessage("SUBSCRIBE"),
                    "MESS_NOT_AVAILABLE" => GetMessage("NOT_AVAILABLE"),
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => GetMessage("GOODS"),
                    "PAGE_ELEMENT_COUNT" => "30",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array(
                    ),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRICE_VAT_SHOW_VALUE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "SEARCH_CHECK_DATES" => "Y",
                    "SEARCH_NO_WORD_LOGIC" => "Y",
                    "SEARCH_PAGE_RESULT_COUNT" => "50",
                    "SEARCH_RESTART" => "N",
                    "SEARCH_USE_LANGUAGE_GUESS" => "Y",
                    "SECTIONS_SHOW_PARENT_NAME" => "Y",
                    "SECTIONS_VIEW_MODE" => "LIST",
                    "SECTION_BACKGROUND_IMAGE" => "-",
                    "SECTION_COUNT_ELEMENTS" => "N",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_TOP_DEPTH" => "3",
                    "SEF_MODE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "Y",
                    "SHOW_404" => "N",
                    "SHOW_DEACTIVATED" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_TOP_ELEMENTS" => "Y",
                    "SIDEBAR_DETAIL_POSITION" => "right",
                    "SIDEBAR_DETAIL_SHOW" => "N",
                    "SIDEBAR_PATH" => "",
                    "SIDEBAR_SECTION_POSITION" => "right",
                    "SIDEBAR_SECTION_SHOW" => "Y",
                    "TEMPLATE_THEME" => "blue",
                    "TOP_ELEMENT_COUNT" => "9",
                    "TOP_ELEMENT_SORT_FIELD" => "sort",
                    "TOP_ELEMENT_SORT_FIELD2" => "id",
                    "TOP_ELEMENT_SORT_ORDER" => "asc",
                    "TOP_ELEMENT_SORT_ORDER2" => "desc",
                    "TOP_ENLARGE_PRODUCT" => "STRICT",
                    "TOP_LINE_ELEMENT_COUNT" => "3",
                    "TOP_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "TOP_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                    "TOP_SHOW_SLIDER" => "Y",
                    "TOP_SLIDER_INTERVAL" => "3000",
                    "TOP_SLIDER_PROGRESS" => "N",
                    "TOP_VIEW_MODE" => "SECTION",
                    "USER_CONSENT" => "N",
                    "USER_CONSENT_ID" => "0",
                    "USER_CONSENT_IS_CHECKED" => "Y",
                    "USER_CONSENT_IS_LOADED" => "N",
                    "USE_COMPARE" => "N",
                    "USE_ELEMENT_COUNTER" => "Y",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_FILTER" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "USE_REVIEW" => "N",
                    "USE_STORE" => "N",
                    "COMPONENT_TEMPLATE" => "rooms",
                    "VARIABLE_ALIASES" => array(
                        "ELEMENT_ID" => "ELEMENT_ID",
                        "SECTION_ID" => "SECTION_ID",
                    )
                ),
                false
            );?>
        </div>
    </section>
<?// ABOUT US ?>
<a name="anc_about"></a>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"about_us", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "atwebsite_novostroy",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "1",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => GetMessage("PAGER_TITLE"),
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "BUTTON_TITLE",
			1 => "BUTTON_LINK",
			2 => "LINK_ACTION",
			3 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "about_us"
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "about_us",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "10",
        "IBLOCK_TYPE" => "atwebsite_novostroy",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "1",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => GetMessage("PAGER_TITLE"),
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "BUTTON_TITLE",
            1 => "BUTTON_LINK",
            2 => "LINK_ACTION",
            3 => "",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "about_us"
    ),
    false
);?>
<?// ABOUT DEV?>
<a name="anc_about_dev"></a>
<section class="about-dev">
        <div class="content">
            <div class="bg-image">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_about-dev_bg-image.php")
                );?>
            </div>
            <div class="wrapper container">
                <div class="content-block">
                    <h3 class="content-title">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include", "",
                            Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_content-title_7.php")
                        );?>
                    </h3>
                    <div class="text ">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include", "",
                            Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_content-about-dev_text.php")
                        );?>
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
        </div>
    </section>
<div class="delimiter"></div>
<?// VISUAL ?>
<a name="anc_visual"></a>
<section class="visual">
    <?$APPLICATION->IncludeComponent("at:interactive.editor", ".default", array(
	"FILE_FORMAT" => "png, jpg, jpeg, gif, bmp",
		"FILE_SIZE" => "10000",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "atwebsite_novostroy",
		"SHOW_ACTIVE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SECTION_ID" => array(
			0 => "1",
		)
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
</section>
<div class="delimiter"></div>
<?// OUR DIFFERENCE?>
<a name="anc_difference"></a>
<section class="our-difference">
    <div class="container">
        <h3 class="content-title"><?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_content-title_2.php")
                    );?></h3>
        <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"our-difference", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "8",
		"IBLOCK_TYPE" => "atwebsite_novostroy",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => GetMessage("PAGER_TITLE"),
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "ICON",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "our-difference",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
    </div>
</section>
<div class="delimiter"></div>
<?// BUILDING?>
<a name="anc_building"></a>
<section class="building">
    <div class="container">
        <h3 class="content-title"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
		"PATH" => INC_FILE_PATH."/inc_content-title_5.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?></h3>
        <?$APPLICATION->IncludeComponent("bitrix:news.list", "building", array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "atwebsite_novostroy",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => GetMessage("PAGER_TITLE"),
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "PICTURES",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "building"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
    </div>
</section>
<div class="delimiter"></div>
<?// DOCUMENTS?>
<a name="anc_documents"></a>
<section class="documents">
    <div class="container">
        <h3 class="content-title"><?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", "",
                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_content-title_6.php")
                    );?></h3>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list", 
            "documents", 
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "Y",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "3",
                "IBLOCK_TYPE" => "atwebsite_novostroy",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => GetMessage("PAGER_TITLE"),
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => array(
                    0 => "",
                    1 => "FILE",
                ),
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "ACTIVE_FROM",
                "SORT_BY2" => "SORT",
                "SORT_ORDER1" => "DESC",
                "SORT_ORDER2" => "ASC",
                "STRICT_SECTION_CHECK" => "N",
                "COMPONENT_TEMPLATE" => "documents"
            ),
            false
        );?>
    </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>