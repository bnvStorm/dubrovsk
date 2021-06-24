<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
</main>
    <footer>
	<?if($APPLICATION->GetCurPage(false) == SITE_DIR){?>
        <?// CONTACTS AND MAP?>
        <a name="anc_contacts"></a>
        <section class="contacts-and-map">
            <div class="content" style="background:linear-gradient(to top right, #211c50, #5ec2af);">
                <div class="map-block">
                    <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view", 
	"map", 
	array(
		"API_KEY" => "",
		"CONTROLS" => array(
			0 => "ZOOM",
		),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:59.84299024894571;s:10:\"yandex_lon\";d:30.91984798993588;s:12:\"yandex_scale\";i:13;s:10:\"PLACEMARKS\";a:4:{i:0;a:3:{s:3:\"LON\";d:30.936501021233;s:3:\"LAT\";d:59.847392741663;s:4:\"TEXT\";s:179:\"Офис продаж###RN###Ленинградская область, Всеволожский район, г.п. Дубровка, ул. Советская, д. 36, корп. 1\";}i:1;a:3:{s:3:\"LON\";d:30.931240216057;s:3:\"LAT\";d:59.841394886007;s:4:\"TEXT\";s:247:\"ЖК \"Невская История\" (есть в Яндекс.Картах)###RN###Ленинградская область, Всеволожский район, г.п. Дубровка, ул. Томилина, д. 9 (корп. 1 и корп. 2)\";}i:2;a:3:{s:3:\"LON\";d:30.939163461487;s:3:\"LAT\";d:59.845233556793;s:4:\"TEXT\";s:0:\"\";}i:3;a:3:{s:3:\"LON\";d:30.939163461487;s:3:\"LAT\";d:59.845233556793;s:4:\"TEXT\";s:182:\" \"Дом на Набережной\"###RN###Ленинградская область, Всеволожский район, г.п. Дубровка, ул. Набережная, д. 10\";}}}",
		"MAP_HEIGHT" => "150%",
		"MAP_ID" => "",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array(
			0 => "ENABLE_DBLCLICK_ZOOM",
			1 => "ENABLE_RIGHT_MAGNIFIER",
			2 => "ENABLE_DRAGGING",
		),
		"COMPONENT_TEMPLATE" => "map",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
                </div>
                <div class="wrapper container">
                    <h3 class="content-title">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-main-title.php")
                        );?>
                    </h3>
                    <div class="content-text">
                        <p>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-phone-3.php")
                            );?>
                        </p>
                        <h4>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-title-1.php")
                            );?>
                        </h4>
                        <p>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-text-1.php")
                            );?>
                        </p>
                        <p>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-phone-1.php")
                            );?>                 
<!--                            --><?//$APPLICATION->IncludeComponent(
//                                "bitrix:main.include",
//                                "",
//                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-phone-2.php")
//                            );?><!--                           -->
<!--                            --><?//$APPLICATION->IncludeComponent(
//                                "bitrix:main.include",
//                                "",
//                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-email.php")
//                            );?>
                        </p>
<!--                        <h4>-->
<!--                            --><?//$APPLICATION->IncludeComponent(
//                                "bitrix:main.include",
//                                "",
//                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-title-2.php")
//                            );?>
<!--                        </h4>-->
<!--                        <p>-->
<!--                            --><?//$APPLICATION->IncludeComponent(
//                                "bitrix:main.include",
//                                "",
//                                Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-text-2.php")
//                            );?>
<!--                        </p>-->

                    </div>
<!--                    <div class="social-links">-->
<!--                        --><?//$APPLICATION->IncludeComponent(
//                            "bitrix:news.list",
//                            "social-footer",
//                            array(
//                                "COMPONENT_TEMPLATE" => "social-footer",
//                                "IBLOCK_TYPE" => "atwebsite_novostroy",
//                                "IBLOCK_ID" => "6",
//                                "NEWS_COUNT" => "20",
//                                "SORT_BY1" => "SORT",
//                                "SORT_ORDER1" => "ASC",
//                                "SORT_BY2" => "ID",
//                                "SORT_ORDER2" => "ASC",
//                                "FILTER_NAME" => "",
//                                "FIELD_CODE" => array(
//                                    0 => "DETAIL_PICTURE",
//                                    1 => "",
//                                ),
//                                "PROPERTY_CODE" => array(
//                                    0 => "LINK",
//                                    1 => "ICON",
//                                ),
//                                "CHECK_DATES" => "Y",
//                                "DETAIL_URL" => "",
//                                "AJAX_MODE" => "N",
//                                "AJAX_OPTION_JUMP" => "N",
//                                "AJAX_OPTION_STYLE" => "Y",
//                                "AJAX_OPTION_HISTORY" => "N",
//                                "AJAX_OPTION_ADDITIONAL" => "",
//                                "CACHE_TYPE" => "A",
//                                "CACHE_TIME" => "36000000",
//                                "CACHE_FILTER" => "N",
//                                "CACHE_GROUPS" => "Y",
//                                "PREVIEW_TRUNCATE_LEN" => "",
//                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
//                                "SET_TITLE" => "N",
//                                "SET_BROWSER_TITLE" => "N",
//                                "SET_META_KEYWORDS" => "N",
//                                "SET_META_DESCRIPTION" => "N",
//                                "SET_LAST_MODIFIED" => "N",
//                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
//                                "ADD_SECTIONS_CHAIN" => "N",
//                                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
//                                "PARENT_SECTION" => "",
//                                "PARENT_SECTION_CODE" => "",
//                                "INCLUDE_SUBSECTIONS" => "Y",
//                                "STRICT_SECTION_CHECK" => "N",
//                                "DISPLAY_DATE" => "N",
//                                "DISPLAY_NAME" => "N",
//                                "DISPLAY_PICTURE" => "Y",
//                                "DISPLAY_PREVIEW_TEXT" => "Y",
//                                "PAGER_TEMPLATE" => ".default",
//                                "DISPLAY_TOP_PAGER" => "N",
//                                "DISPLAY_BOTTOM_PAGER" => "N",
//                                "PAGER_TITLE" => "",
//                                "PAGER_SHOW_ALWAYS" => "N",
//                                "PAGER_DESC_NUMBERING" => "N",
//                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
//                                "PAGER_SHOW_ALL" => "N",
//                                "PAGER_BASE_LINK_ENABLE" => "N",
//                                "SET_STATUS_404" => "N",
//                                "SHOW_404" => "N",
//                                "MESSAGE_404" => ""
//                            ),
//                            false
//                        );?>
<!--                    </div>-->
                    <div class="button-wrapper">
                        <div class="order-button">
                            <a href="#">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_footer-btn-text.php")
                                );?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?}?>
    </footer>
    <div id="user-politic-modal">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array("AREA_FILE_SHOW" => "file", "PATH" => INC_FILE_PATH."/inc_user-politic.php")
    );?>
    </div>
    <a href="#top" id="jsMoveTop"><i class="fa fa-chevron-up"></i></a>
    <?if ($USER->IsAdmin() && COption::GetOptionString('atwebsite.novostroy', "theme_panel") != "Y"):?>
        <div id="jsThemeEdit">
            <i class="fa fa-paint-brush"></i>
            <div id="jsThemeSet" class="d-none">
                <span data-theme="theme-default"><?=GetMessage('T_FOOTER_THEME_DEFAULT')?></span>
                <span data-theme="theme-01"><?=GetMessage('T_FOOTER_THEME_NAME_1')?></span>
                <span data-theme="theme-02"><?=GetMessage('T_FOOTER_THEME_NAME_2')?></span>
                <span data-theme="theme-03"><?=GetMessage('T_FOOTER_THEME_NAME_3')?></span>
                <span data-theme="theme-04"><?=GetMessage('T_FOOTER_THEME_NAME_4')?></span>
            </div>
        </div>
    <?endif;?>
</body>
<!-- SCRIPTS -->
<!--[if lt IE 9]>
<script src="<?=SITE_TEMPLATE_PATH?>/js/html5shiv.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/respond.min.js"></script>
<![endif]-->
<?$asset->AddJs(SITE_TEMPLATE_PATH.'/js/slick.min.js');?>
<?$asset->AddJs(SITE_TEMPLATE_PATH.'/js/animate.js');?>
<?$asset->AddJs(SITE_TEMPLATE_PATH.'/js/jquery.plugins.js');?>
<?$asset->AddJs(SITE_TEMPLATE_PATH.'/js/script.js');?>
</html>