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
<div class="team-carousel carousel owl-carousel js-carousel-one">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
<div class="team-carousel-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
	<div class="team-carousel-item-pic" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>');">
		<img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" />
	</div>
<?else:?>
	<div class="team-carousel-item-pic"></div>
<?endif;?>
	<div class="team-carousel-item-content">
		<div class="team-carousel-item-header">
			<div class="h3 team-carousel-item-title">Михаил Турецкий</div>
		<?if (isset($arItem["DISPLAY_PROPERTIES"]['POST']['DISPLAY_VALUE']) && !empty($arItem["DISPLAY_PROPERTIES"]['POST']['DISPLAY_VALUE']))
			echo $arItem["DISPLAY_PROPERTIES"]['POST']['DISPLAY_VALUE'];?>
		</div>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<p><?echo $arItem["PREVIEW_TEXT"];?></p>
		<?endif;?>
		<?if (isset($arItem["DISPLAY_PROPERTIES"]['EMAIL']['VALUE']) && !empty($arItem["DISPLAY_PROPERTIES"]['EMAIL']['VALUE'])):?>
		<hr>
		<a href="mailto:<?=$arItem["DISPLAY_PROPERTIES"]['EMAIL']['VALUE']?>" class="team-carousel-item-email"><?=$arItem["DISPLAY_PROPERTIES"]['EMAIL']['VALUE']?></a>
		<?endif;?>
	</div>
</div>
<?endforeach;?>
</div>
