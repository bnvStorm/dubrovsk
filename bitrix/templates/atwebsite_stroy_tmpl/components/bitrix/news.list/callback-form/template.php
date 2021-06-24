<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="popup-callback callback-form call">
    <span class="close-form">&#215;</span>
    <div class="form-wrapper">
        <form id="jsGetCallback" method="POST" action="">
            <h3 class="form-title call"><?=GetMessage('TITLE_TEXT_CALL');?></h3>
            <h3 class="form-title order"><?=GetMessage('TITLE_TEXT_ORDER');?></h3>
            <div class="detail-info"></div>
            <label class="name">
                <span class="subtitle"><?=GetMessage('INPUT_NAME_TEXT')?></span>
                <input type="text" name="name" required>
            </label>
            <label class="phone">
                <span class="subtitle"><?=GetMessage('INPUT_PHONE_TEXT')?></span>
                <input type="text" name="phone" placeholder="+7 900 123 45 67" required>
            </label>
            <label class="email">
                <span class="subtitle"><?=GetMessage('INPUT_EMAIL_TEXT')?></span>
                <input type="text" name="email">
            </label>
            <label class="message">
                <span class="subtitle"><?=GetMessage('TEXTAREA_TITLE')?></span>
                <textarea name="message"></textarea>
            </label>
            <p class="info-message call"><?=GetMessage('SUBMIT_MESS_TEXT')?><a href="javascript:void(0);" data-fancybox data-src="#user-politic-modal"><?=GetMessage('SUBMIT_MESS_LINK')?></a></p>
            <div class="send-button">
                <input type="submit" value="<?=GetMessage('BTN_TEXT')?>">
            </div>
            <p class="info-message order"><?=GetMessage('SUBMIT_MESS_TEXT')?><a href="javascript:void(0);" data-fancybox data-src="#user-politic-modal"><?=GetMessage('SUBMIT_MESS_LINK')?></a></p>
        </form>
        <div class="bg-image">
            <img src="/bitrix/templates/atwebsite_stroy/images/form-bg.png">
        </div>
    </div>
</div>

<script>
BX.message({
    IBLOCK_FORM_ID:    "<?=$arResult['ID']?>",
    TMP_FORM_PATH:     "<?=$templateFolder?>/ajax/",
    ERR_EMPTY_VALUE:   "<?=GetMessage('ERR_EMPTY_VALUE')?>",
    ERR_VALUE_NAME:    "<?=GetMessage('ERR_VALUE_NAME')?>",
    ERR_VALUE_PHONE:   "<?=GetMessage('ERR_VALUE_PHONE')?>",
    ERR_VALUE_EMAIL:   "<?=GetMessage('ERR_VALUE_EMAIL')?>",
    ERR_VALUE_MESSAGE: "<?=GetMessage('ERR_VALUE_MESSAGE')?>",
    ERR_RESULT:        "<?=GetMessage('ERR_RESULT')?>",
    RESULT_OK:         "<?=GetMessage('RESULT_OK')?>",
    POST_ID:           "<?=$arParams['POST_ID']?>",
    POST_TYPE:         "<?=$arParams['POST_TYPE']?>",
    MESS_CALLBACK:     "<?=GetMessage('MESS_CALLBACK')?>",
    MESS_ORDER:        "<?=GetMessage('MESS_ORDER')?>",
});
</script>

