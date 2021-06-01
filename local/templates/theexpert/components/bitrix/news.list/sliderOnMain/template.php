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
<div class="slides-wrap">
	<div id="slider">
		<div class="slides-container">
<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="slides-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                    <img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"/>
				<?endif;?>
                    <div class="scrollable">
                        <div class="slides-item-content">
                            <div class="slides-item-align">
                                <div class="container">
                                    <div class="slides-item-header">
									<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                                        <div class="slides-item-title"><?echo $arItem["NAME"]?></div>
									<?endif;?>
                                        <div class="slides-item-nav">
                                            <div class="slides-item-prev">
                                                <a href="javascript:" class="slides-item-prev-link">
<? $prevKey = $keyItem - 1;
$nextKey = $keyItem + 1;
$countItems = count($arResult["ITEMS"]);

if ($prevKey < 0)
	if ($countItems == 1)
		$prevKey = $keyItem;
	else
		$prevKey = $countItems - 1;

if ($nextKey > $countItems - 1)
	if ($countItems == 1)
		$nextKey = $keyItem;
	else
		$nextKey = 0;
?>
                                                    <span class="slides-item-prev-text"><?=$arResult["ITEMS"][$prevKey]["NAME"]?></span>
                                                    <span class="slides-item-prev-arrow"></span>
                                                </a>
                                            </div>
                                            <div class="slides-item-next">
                                                <a href="javascript:" class="slides-item-next-link">
                                                    <span class="slides-item-next-arrow"></span>
                                                    <span class="slides-item-next-text"><?=$arResult["ITEMS"][$nextKey]["NAME"]?></span>
                                                </a>
                                            </div>
                                        </div>
										<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
										<p><?echo $arItem["PREVIEW_TEXT"];?></p>
										<?endif;?>
                                    </div>
                                    <a href="/catalog/" class="btn btn-brick">Каталог</a>
                                </div>
                            </div>
                        </div>
                    </div>
	</div>
<?endforeach;?>
		</div>
	</div>
	<a href="#intro" class="slides-scroll js-scroll">
		<i class="icon icon-arrow-down"></i>
	</a>
	<a href="/catalog/" class="btn btn-brick slides-catalog"><?=GetMessage('SLIDER_ON_MAIN_CATALOG_NAME')?></a>
</div>
