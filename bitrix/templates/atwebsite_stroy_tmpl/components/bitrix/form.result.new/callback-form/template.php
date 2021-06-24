<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<span class="close-form">&#215;</span>
<div class="form-wrapper">
<?if ($arResult["isFormErrors"] == "Y"):?>
    <p class="info-message error">
    <?=$arResult["FORM_ERRORS_TEXT"];?>
    </p>
<?endif;?>
<?if ($arResult["isFormNote"] == "Y") {?>
    <p class="info-message"><?=$arResult["FORM_NOTE"]?></p>
<?
}
?>
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
	<label>
		<span class="subtitle"><?=$arQuestion["CAPTION"]?></span>
		<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
		<?=$arQuestion["HTML_CODE"]?>
	</label>
    <?
	}
}
?>
<p class="politic-message"><?=GetMessage('SUBMIT_MESS_TEXT')?><a href="javascript:void(0);" data-fancybox data-src="#user-politic-modal"><?=GetMessage('SUBMIT_MESS_LINK')?></a></p>
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
<?=$arResult["FORM_FOOTER"]?>
    <div class="bg-image">
        <?if ($arResult["FORM_IMAGE"]):?><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>"><?endif;?>
    </div>
</div>
<script>
BX.message({
    ERR_VALUE_NAME:    "<?=GetMessage('ERR_VALUE_NAME')?>",
    ERR_VALUE_PHONE:   "<?=GetMessage('ERR_VALUE_PHONE')?>",
    ERR_VALUE_EMAIL:   "<?=GetMessage('ERR_VALUE_EMAIL')?>",
    ERR_VALUE_MESSAGE: "<?=GetMessage('ERR_VALUE_MESSAGE')?>",
    RESULT_OK:         "<?=GetMessage('RESULT_OK')?>",
    REG_EXP_RUS_RANGE: "<?=GetMessage('REG_EXP_RUS_RANGE')?>",
});
</script>