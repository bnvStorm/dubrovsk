<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<div class="wrapper container">
    <div class="content-image wow fadeIn"></div>
    <div class="content-block wow fadeIn">
        <h4 class="title"></h4>
        <div class="text"></div>
        <div class="order-button"><a href=""><?=GetMessage('MESS_CALLBACK')?></a></div>
        <div class="actions-timer">
            <h4 class="title"><?=GetMessage('MESS_ACTION_TEXT')?></h4>
            <div class="info"></div>
        </div>
    </div>
    <div class="content-tabs row justify-content-center">
        <?$count = 1;
        foreach ($arResult['ITEMS'] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="<?if($count==1) echo 'active';?> tab col-12 col-md-6 col-lg-3" data-id="<?=$arItem['ID']?>">
            <span class="num">0<?=$count?></span>
            <span class="title"><?=$arItem["NAME"]?></span>
        </div>
        <?$count++;
        endforeach;?>
    </div>
</div>
<script>
    BX.message({
        TIMER_DAYS:    "<?=GetMessage('TIMER_DAYS')?>",
        TIMER_HOURS:   "<?=GetMessage('TIMER_HOURS')?>",
        TIMER_MINUTES: "<?=GetMessage('TIMER_MINUTES')?>",
        TIMER_SECONDS: "<?=GetMessage('TIMER_SECONDS')?>"
    });
    $(function(){
        $('.actions .content .content-tabs .tab').click(function(event) {
            let itemID = $(this).attr('data-id');
            let templateFolder = "<?=$templateFolder?>";
            $('.actions .content .content-tabs .tab').removeClass('active');
            $(this).addClass('active');
            $.ajax({
               url: templateFolder+'/tab-data.ajax.php',
               type: 'POST',
               dataType: 'json',
               data: {ITEM_ID: itemID},
            })
            .done(function(ajaxResult) {
                $('.actions .content-block').hide();
                if (ajaxResult.showButton !== 'YES') $('.actions .order-button').hide();
                if (ajaxResult.bgImage) {
                    $('.actions .content-image').css('backgroundImage', 'url('+ajaxResult.bgImage+')').show();
                } else {
                    $('.actions .content-image').hide();
                }
                $('.actions .content-block > .title').html(ajaxResult.contentTitle);
                $('.actions .content-block > .text').html(ajaxResult.contentText);
                $('.actions').find('.actions-timer .info').html('');
                if (ajaxResult.showTimer == 'YES') {
                    $('.actions').find('.actions-timer').show();
                    $('.actions').find('.actions-timer .info').dsCountDown({
                        endDate: new Date(ajaxResult.endDate),
                        titleDays: BX.message("TIMER_DAYS"),
                        titleHours: BX.message("TIMER_HOURS"),
                        titleMinutes: BX.message("TIMER_MINUTES"),
                        titleSeconds: BX.message("TIMER_SECONDS")
                    });
                } else {
                    $('.actions').find('.actions-timer').hide();
                }
                $('.actions .content-block').show();
            });
        });
		$('.actions .content .content-tabs .tab:eq(0)').trigger('click');
        $('body').find('.actions .content-block .order-button a').click(function(event) {
            event.preventDefault();
            event.stopPropagation();
            $('body').find('.header__top-line .header-button a').trigger('click');
        });
    });
</script>