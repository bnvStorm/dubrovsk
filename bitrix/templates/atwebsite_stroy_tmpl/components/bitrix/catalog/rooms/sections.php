<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */

/** @var CBitrixComponent $component */
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server;

CModule::IncludeModule('iblock');

$context = Context::getCurrent();
$request = $context->getRequest();

$this->setFrameMode(true);

function nfGetCurPageParam( $strParam = '', $arParamKill = array(), $get_index_page = NULL ) {
    if (NULL === $get_index_page) {
        if (defined('BX_DISABLE_INDEX_PAGE')) {
            $get_index_page = !BX_DISABLE_INDEX_PAGE;
        } else {
            $get_index_page = TRUE;
        }
    }

    $sUrlPath = GetPagePath(FALSE, $get_index_page);
    $strNavQueryString = nfDeleteParam($arParamKill);

    if ($strNavQueryString <> '' && $strParam <> '') {
        $strNavQueryString = '&'.$strNavQueryString;
    }

    if ($strNavQueryString == '' && $strParam == '') {
        return $sUrlPath;
    }

    return $sUrlPath.'?'.$strParam.$strNavQueryString;  
}


function nfDeleteParam($arParam) {
   if (sizeof($_GET) < 1) { return ''; }
   if (sizeof($arParam) < 1) { return ''; }

   $get = $_GET;

    foreach ($arParam as $param) {
        $search    = &$get;
        $param     = (array)$param;
        $lastIndex = sizeof($param) - 1;

        foreach ($param as $c => $key) {
            if (array_key_exists($key, $search)) {
                if ($c == $lastIndex) {
                   unset($search[$key]);
                } else {
                   $search = &$search[$key];
                }
            }
        }
    }

    return str_replace(
        array('%5B', '%5D'),
        array('[', ']'),
        http_build_query($get)
    );
} 

global $arSectionFilter;
foreach ($request as $code => $val) {
    if ($code == 'id')
        continue;
    if ($code == 'UF_STATUS') {
        $rsData = CUserFieldEnum::GetList(["SORT" => "ASC"], ["USER_FIELD_NAME" => "UF_STATUS", "XML_ID" => 'STROY_'.$val[0]]);
        if ($arRes = $rsData->Fetch()) {
            $arSectionFilter[$code] = $arRes["ID"];
        }
        continue;
    }
    switch ($code) {
        case 'SQUARE_MIN': $arSectionFilter['>=UF_SQUARE'] = $val;
            break;
        case 'SQUARE_MAX': $arSectionFilter['<=UF_SQUARE'] = $val;
            break;
        case 'PRICE_MIN': $arSectionFilter['>=UF_PRICE'] = $val;
            break;
        case 'PRICE_MAX': $arSectionFilter['<=UF_PRICE'] = $val;
            break;
        default: $arSectionFilter[$code] = $val;
            break;
    }
}

$arUf = [];
$rsData = CUserTypeEntity::GetList(["ID" => "DESC"], ["ENTITY_ID" => "IBLOCK_" . $arParams["IBLOCK_ID"] . "_SECTION", "LANG" => "ru"]);
while ($arRes = $rsData->Fetch()) {
    if (!$arRes['XML_ID'] || explode('---', $arRes['XML_ID'])[0] != 'service') { continue; }
    $arUf[$arRes["FIELD_NAME"]] = $arRes;
}

function getHrefParams($nameField, $key, $value, $array) {
    $href = nfGetCurPageParam($nameField . "[" . $key . "]=" . $value, array(array($nameField, $key)));
    if (is_array($array[$nameField]) && in_array($value, $array[$nameField])) {
        $key1 = array_search($value, $array[$nameField]);
        $href = nfGetCurPageParam("", array(array($nameField, $key)));
    }

    return $href;
}

$arFilter = array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'DEPTH_LEVEL' => [2, 3], 'ACTIVE' => 'Y');
$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter, false, ["UF_*"]);
?>
<div class="smart-filter row">
    <a href="<?=SITE_DIR?>" class="clear-filter"><?=GetMessage("RESET_BTN")?></a>
    <div class="col-12 col-lg-4 house">
        <h4><?= GetMessage("HOUSE_TITLE"); ?></h4>
        <div class="params">
            <?
            $key = 0;
            while ($arSect = $rsSections->Fetch()) {
                if ($arSect["DEPTH_LEVEL"] == 3) {
                    if ((!is_array($arSectionFilter["SECTION_ID"]) || !in_array($arSect["IBLOCK_SECTION_ID"], $arSectionFilter["SECTION_ID"])) && !empty($arSectionFilter["SECTION_ID"]))
                        continue;
                    foreach ($arUf as $code => $uf_val) {
                        if (!is_array($arUf[$code]["VALUES"]) || !in_array($arSect[$code], $arUf[$code]["VALUES"])) {
                            $arUf[$code]["VALUES"][] = $arSect[$code];
                        }
                    }
                } elseif ($arSect["DEPTH_LEVEL"] == 2) {
                    $sectCount = CIBlockSection::GetCount(array('IBLOCK_ID' => $arParams["IBLOCK_ID"],'SECTION_ID' => $arSect['ID']));
                    if($sectCount != 0) {
                        $href = getHrefParams("SECTION_ID", $key, $arSect["ID"], $request);
                        ?>
                        <a id="house_<?= $arSect["ID"] ?>" href="<?= $href; ?>" title="<?= htmlspecialchars($arSect["NAME"]) ?>">
                            <span class="<?= (in_array($arSect["ID"], $request["SECTION_ID"]) ? "active" : "") ?>"><?= $arSect["NAME"] ?></span>
                        </a>
                    <?}?>
        <?
        $key++;
    }
}
?>
        </div>
    </div>

        <? foreach ($arUf as $field): ?>
            <?
            switch ($field["USER_TYPE_ID"]) {
                case "double":
                case "integer":
                    ?>
                <div class="col-12 col-md-6 col-lg-4 interval-filter">
                    <?
                    sort($field["VALUES"]);
                    switch ($field["FIELD_NAME"]) {
                        case 'UF_SQUARE':
                            $href = $APPLICATION->GetCurPageParam('SQUARE_MIN=' . $field["VALUES"][0] . '&SQUARE_MAX=' . $field["VALUES"][count($field["VALUES"]) - 1], Array('SQUARE_MIN', 'SQUARE_MAX'));

                            if ($request['SQUARE_MIN'] && $request['SQUARE_MAX']) {
                                $minValue = $field["VALUES"][0];
                                $maxValue = $field["VALUES"][count($field["VALUES"]) - 1];
                                $minCurrent = $request['SQUARE_MIN'];
                                $maxCurrent = $request['SQUARE_MAX'];
                            } else {
                                $minValue = $minCurrent = $field["VALUES"][0];
                                $maxValue = $maxCurrent = $field["VALUES"][count($field["VALUES"]) - 1];
                            }
                            break;
                        case 'UF_PRICE':
                            $href = $APPLICATION->GetCurPageParam('PRICE_MIN=' . $field["VALUES"][0] . '&PRICE_MAX=' . $field["VALUES"][count($field["VALUES"]) - 1], Array('PRICE_MIN', 'PRICE_MAX'));

                            if ($request['PRICE_MIN'] && $request['PRICE_MAX']) {
                                $minValue = $field["VALUES"][0];
                                $maxValue = $field["VALUES"][count($field["VALUES"]) - 1];
                                $minCurrent = $request['PRICE_MIN'];
                                $maxCurrent = $request['PRICE_MAX'];
                            } else {
                                $minValue = $minCurrent = $field["VALUES"][0];
                                $maxValue = $maxCurrent = $field["VALUES"][count($field["VALUES"]) - 1];
                            }
                            break;
                    }
                    ?>
                    <script>
                        $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>]').slider({
                            animate: "fast",
                            range: true,
                            min: <?= $minValue?>,
                            max: <?= $maxValue?>,
                            values: [ <?= $minCurrent?>, <?= $maxCurrent?> ],
                            slide : function(event, ui) {
                                let minLeft = $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .ui-slider-handle:eq(0)').css('left');
                                let maxLeft = $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .ui-slider-handle:eq(1)').css('left');
                                $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .min-value').text(ui.values[0]).css('left', minLeft);
                                $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .max-value').text(ui.values[1]).css('left', maxLeft);
                                if (minLeft == maxLeft) {
                                    $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .max-value').hide();
                                } else {
                                    $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .max-value').show();
                                }
                            }
                        });
                        var minLeftPos = $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .ui-slider-handle:eq(0)').css('left');
                        var maxLeftPos = $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .ui-slider-handle:eq(1)').css('left');

                        if (minLeftPos != '0px') {
                            $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .min-value').css('left', minLeftPos).addClass('text-right');
                        }
                        if ($('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .ui-slider-handle:eq(1)').attr('style') != 'left: 100%;') {
                            $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .max-value').css('left', maxLeftPos).addClass('text-left');
                        }
                        if (minLeftPos == maxLeftPos) {
                            $('body').find('.choose-room [data-uf=<?= $field["FIELD_NAME"]?>] .max-value').hide();
                        }
                    </script>
                    <h4><?= $field["LIST_FILTER_LABEL"] ?></h4>
                    <div class="interval" data-uf="<?= $field["FIELD_NAME"] ?>">
                        <div class="value-block">
                            <a class="change-interval-value" href="<?= $href ?>"></a>
                            <span class="min-value"><?= $minCurrent ?></span>
                            <span class="max-value"><?= $maxCurrent ?></span>
                        </div>
                    </div>
                </div>
                        <? break; ?>
                    <? case "string": ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <h4><?= $field["LIST_FILTER_LABEL"] ?></h4>
                    <div class="params">
                        <?
                        asort($field["VALUES"]);
                        foreach ($field["VALUES"] as $key => $value) {
                            $href = getHrefParams($field["FIELD_NAME"], $key, $value, $request);
                            ?>
                            <a href="<?= $href; ?>">
                                <span class="<?= (in_array($value, $request[$field["FIELD_NAME"]]) ? "active" : "") ?>"><?= $value ?></span>
                            </a>
            <? } ?>
                    </div>
                </div>
            <? break; ?>
    <? } ?>
<? endforeach; ?>
    <div class="col-12 col-md-6 col-lg-4 pt-3">
        <h4 style="color: transparent; margin-bottom: 10px;">hidden</h4>
        <div class="">
            <input type="checkbox" name="UF_STATUS" <?= (is_array($request["UF_STATUS"]) && in_array("FREE", $request["UF_STATUS"]) ? "checked" : "") ?>>
            <a style="display:none;" id="UF_STATUS" href="<?= getHrefParams("UF_STATUS", 0, "FREE", $request); ?>"></a>
            <span><?= GetMessage("ONLY_FREE") ?></span>
        </div>
    </div>
</div>
<?
$APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "",
        array(
            "IBLOCK_TYPE"        => $arParams["IBLOCK_TYPE"],
            "FILTER_NAME"        => "arSectionFilter",
            "IBLOCK_ID"          => $arParams["IBLOCK_ID"],
            "CACHE_TYPE"         => $arParams["CACHE_TYPE"],
            "CACHE_TIME"         => $arParams["CACHE_TIME"],
            "CACHE_GROUPS"       => $arParams["CACHE_GROUPS"],
            "COUNT_ELEMENTS"     => $arParams["SECTION_COUNT_ELEMENTS"],
            "TOP_DEPTH"          => $arParams["SECTION_TOP_DEPTH"],
            "SECTION_URL"        => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "VIEW_MODE"          => $arParams["SECTIONS_VIEW_MODE"],
            "SHOW_PARENT_NAME"   => $arParams["SECTIONS_SHOW_PARENT_NAME"],
            "HIDE_SECTION_NAME"  => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
            "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
        ),
        $component,
        ($arParams["SHOW_TOP_ELEMENTS"] !== "N" ? array("HIDE_ICONS" => "Y") : array())
);
?>