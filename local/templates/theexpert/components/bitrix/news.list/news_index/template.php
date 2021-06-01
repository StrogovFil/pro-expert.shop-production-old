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
<div class="main-profile-carousel owl-carousel js-carousel-nomobile">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="main-profile-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="main-profile-item-title"><?=$arItem['NAME']?></div>
		<div class="main-profile-item-text"><?=$arItem['PREVIEW_TEXT']?></div>
	<?if (isset($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'])):
		foreach($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'] as $key => $value):?>
		<div class="main-profile-item-name"><?=$value['NAME']?></div>
		<?endforeach;
	endif;?>
	</a>
<?endforeach;?>
</div>