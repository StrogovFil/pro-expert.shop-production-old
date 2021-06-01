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

if (count($arResult["ITEMS"])):
?>

<div class="container">
	<div class="owl-carousel owl-carousel-def js-carousel-def-about">
		<?foreach($arResult["ITEMS"] as $arItem):
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			if (isset($arItem['PROPERTIES'][30]['VALUE']) && !empty($arItem['PROPERTIES'][30]['VALUE'])):
				foreach($arItem['PROPERTIES'][30]['VALUE'] as $pictureId):
					$picturePath = CFile::GetPath($pictureId);
					$dbPictureParams = CFile::GetByID($pictureId);

					if ($arPictureParams = $dbPictureParams->Fetch()):
		?>
					<a id="<?=$this->GetEditAreaId($arItem['ID']);?>" href="<?=$picturePath?>" class="carousel-auto-item" data-fancybox="carousel">
						<img border="0" src="<?=$picturePath?>" alt="" title=""/>
						<span class="carousel-auto-item-mask"></span>
					</a>
		<?			endif;
				endforeach;
			endif;
		endforeach;?>
	</div>
</div>

<?endif?>
