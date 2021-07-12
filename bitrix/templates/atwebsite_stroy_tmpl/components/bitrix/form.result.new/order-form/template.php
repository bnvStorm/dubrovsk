<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<span class="close-form">&#215;</span>
<div class="form-wrapper">
<?if ($arResult["isFormErrors"] == "Y"):?>
    <p class="info-message error">
    <?=$arResult["FORM_ERRORS_TEXT"];?>
    </p>
<?endif;?>
	<?=$arResult["FORM_HEADER"]?>
	<?if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
		if ($arResult["isFormTitle"]) {?>
	<h3 class="form-title call"><?=$arResult["FORM_TITLE"]?></h3>
	<?
	}
}
foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
	if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
		echo $arQuestion["HTML_CODE"];
	}
    else
    {
    ?>
    <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
        <span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
    <?endif;?>
    <?if ($FIELD_SID == 'FORM_SECTION_ID') {
        echo $arQuestion["HTML_CODE"];
        continue;
    }?>
    <?if ($FIELD_SID != 'FORM_DETAIL'):?>
	<label>
		<span class="subtitle"><?=$arQuestion["CAPTION"]?><?/*if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;*/?></span>
		<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
		<?=$arQuestion["HTML_CODE"]?>
	</label>
    <?else:?>
    <label>
        <?=$arQuestion["HTML_CODE"]?>
        <div class="detail-info"></div>
    </label>
    <?endif;?>
    <?
	}
}
?>
<?
if($arResult["isUseCaptcha"] == "Y") {
?>
<?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?>
<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>
<input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
<?
} // isUseCaptcha
?>
<div class="send-button">
	<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
</div>
    <p>Почта отдела продаж: <a href="mailto:lenoblstroy47@yandex.ru">lenoblstroy47@yandex.ru</a></p>
<p class="politic-message"><?=GetMessage('SUBMIT_MESS_TEXT')?><a href="javascript:void(0);" data-fancybox data-src="#user-politic-modal"><?=GetMessage('SUBMIT_MESS_LINK')?></a></p>
<?=$arResult["FORM_FOOTER"]?>
    
</div>

<script>
BX.message({
    ERR_VALUE_NAME:    "<?=GetMessage('ERR_VALUE_NAME')?>",
    ERR_VALUE_PHONE:   "<?=GetMessage('ERR_VALUE_PHONE')?>",
    ERR_VALUE_EMAIL:   "<?=GetMessage('ERR_VALUE_EMAIL')?>",
    ERR_VALUE_MESSAGE: "<?=GetMessage('ERR_VALUE_MESSAGE')?>",
    RESULT_OK:         "<?=GetMessage('RESULT_OK')?>",
    REG_EXP_RUS_RANGE: "<?=GetMessage('REG_EXP_RUS_RANGE')?>"
});
</script>