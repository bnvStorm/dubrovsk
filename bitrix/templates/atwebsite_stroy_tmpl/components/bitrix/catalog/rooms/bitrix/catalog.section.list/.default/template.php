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
$curSectionName = '';
$curSectionPrice = '';
$curSectionRooms = '';
$curSectionSquare = '';
$curSectionFloor = '';
$arRoomsTitle = [
	0 => GetMessage('MESS_ROOM_0'),
	1 => GetMessage('MESS_ROOM_1'),
	2 => GetMessage('MESS_ROOM_2'),
	3 => GetMessage('MESS_ROOM_3'),
	4 => GetMessage('MESS_ROOM_4'),
];
?>
<div class="rooms-selector">
	<p class="alert-message"><?=GetMessage('MESS_NOT_FOUND')?></p>
    <span class="rooms-show-hide opened" style="background: url('<?=SITE_TEMPLATE_PATH?>/images/dropdown.png') no-repeat center;"><?=GetMessage('SHOW_LIST')?></span>
    <span class="rooms-show-hide" style="background: url('<?=SITE_TEMPLATE_PATH?>/images/dropup.png') no-repeat center;"><?=GetMessage('HIDE_LIST')?></span>
	<div class="rooms-list bx_sitemap">
		<ul class="bx_sitemap_ul">
			<?foreach ($arResult['SECTIONS'] as &$arSection):
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
				?>
				<li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>" data-id="<?=$arSection['ID']?>"
					class="list-item <?
					if ($arSection['ID'] == $arResult['SECTION']['ID']) {
						echo "active";
						$curSectionName = $arSection['NAME'];
					} else {
						echo "";
					}?>">
					<a href="<?=$APPLICATION->GetCurPageParam("id=".$arSection['ID'], array("id"));?>"><?=$arSection['NAME']?></a>
				</li>
			<?endforeach;?>
		</ul>
	</div>
	<div style="clear: both;"></div>

	<?if(!empty($arResult['SECTION'])){?>
	<div class="rooms-detail row <?=$arResult['SECTION']["STATUS_CLASS"]?>" style="opacity: 1;">
		<div class="left-side col-7">
            <input id="sectionId" type="hidden" value="<?=$arResult['SECTION']['ID']?>">
			<?if(!empty($arResult['SECTION']['PICTURE'])){?>
				<a href="<?=$arResult['SECTION']['PICTURE']['SRC']?>" data-fancybox="images"><img class="preview-picture" src="<?=$arResult['SECTION']['PICTURE']['SRC']?>" alt="<?=$arResult['SECTION']['PICTURE']['ALT']?>" title="<?=$arResult['SECTION']['PICTURE']['TITLE']?>"></a>
			<?}?>
			<div class="short-info row justify-content-between">
				<?foreach($arResult['UF_FIELDS']['service'] as $code=>$arVal):
				switch ($code) {
					case 'UF_ROOMS_COUNT': $curSectionRooms = $arResult['SECTION'][$code]; break;
					case 'UF_PRICE': $curSectionPrice = number_format($arResult['SECTION'][$code], 0, '', ' '); break;
					case 'UF_SQUARE': $curSectionSquare = $arResult['SECTION'][$code]; break;
					case 'UF_FLOOR': $curSectionFloor = $arResult['SECTION'][$code]; break;
				}
				$itemClass = ($code == 'UF_PRICE')? 'info-item col-12': 'info-item col-6 col-md-4';
				?>

					<div class="<?=$itemClass?>">
						<span class="prop-<?=strtolower($code).$curSectionRooms?>"><?=is_numeric($arResult['SECTION'][$code]) ? number_format($arResult['SECTION'][$code], 0, '', ' ') : $arResult['SECTION'][$code]?></span>
						<p><?=$arVal["EDIT_FORM_LABEL"]?></p>
					</div>
				<?endforeach;?>
			</div>
		</div>
		<div class="right-side col-5">
            <?if($USER->IsAdmin()):?>
                <div class="cm-statuses">
                    <select name="cm-status">
                    <?foreach($arResult["STATUS_LIST"] as $status):?>
                        <option value="<?=$status['ID']?>" data-code="<?=$status['XML_ID']?>"><?=$status['VALUE']?></option>
                    <?endforeach;?>
                    </select>
                    <span><?=GetMessage("CHANGE_STATUS")?></span>
                </div>
            <?endif;?>
			<p class="room-status <?=($arResult['SECTION']["STATUS_CLASS"] ? $arResult['SECTION']["STATUS_CLASS"] : $arResult['DEFAULT_STATUS_CLASS'])?>"><?=($arResult['SECTION']["STATUS_NAME"] ? $arResult['SECTION']["STATUS_NAME"] : GetMessage("DEFAULT_STATUS"))?></p>
			<?if(!empty($arResult['SECTION']['MORE_PHOTO'])){?>
				<div class="more-pictures">
					<?foreach($arResult['SECTION']['MORE_PHOTO'] as $photo){?>
						<a href="<?=CFile::GetPath($photo)?>" data-fancybox="images"><img src="<?=CFile::GetPath($photo)?>"></a>
					<?}?>
				</div>
			<?}?>
			<div class="properties">
				<ul>
					<li>
						<span class="prop-title"><?=GetMessage("HOUSE_TITLE")?></span>
						<span class="prop-value"><?=$arResult['SECTION']["IBLOCK_SECTION_INFO"]["NAME"]?></span>
					</li>
					<?foreach($arResult['UF_FIELDS']['desc'] as $code=>$arVal):?>
						<?if(!$arResult['SECTION'][$code]) continue;?>
						<li>
							<span class="prop-title"><?=$arVal["EDIT_FORM_LABEL"]?></span>
							<span class="prop-value"><?=$arResult['SECTION'][$code]?></span>
						</li>
					<?endforeach;?>
					<?if($arResult['SECTION']["DESCRIPTION"]){?>
						<li>
							<?=$arResult['SECTION']["DESCRIPTION"]?>
						</li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>
	<?}?>
	<div class="detail-info d-none">
        <div class="image" style="background-image: url(<?=$arResult['SECTION']['PICTURE']['SRC']?>);"></div>
        <div class="text">
            <p><?=$curSectionName?> <?=($arRoomsTitle[$curSectionRooms])? $arRoomsTitle[$curSectionRooms]: $arRoomsTitle[0];?></p>
            <p><b><?=$curSectionPrice?></b> <?=GetMessage('MESS_VALUE_RUB')?></p>
            <p><b><?=$curSectionSquare?></b> <?=GetMessage('MESS_VALUE_SQUARE')?></p>
            <p><b><?=$curSectionFloor?></b> <?=GetMessage('MESS_VALUE_FLOOR')?></p>
        </div>
    </div>
</div>
<script>
BX.message({SITE_DIR: "<?=SITE_DIR?>"});
</script>