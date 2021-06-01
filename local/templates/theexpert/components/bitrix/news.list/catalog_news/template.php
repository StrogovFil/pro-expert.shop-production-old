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
<?if (count($arResult["ITEMS"])):?>
<!--section class="interesting" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5"
             data-image-src="<?=SITE_TEMPLATE_PATH?>/images/interesting-1.jpeg"
             style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/interesting-1.jpeg');">
        <div class="container">
            <div class="h1 interesting-title">Вам может быть интересно</div>
			<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
            <div class="interesting-row">
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="interesting-row-pic" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');">
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
                </a>
                <div class="interesting-row-content">
                    <div class="h2 interesting-row-title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                    <div class="interesting-row-text"><?=htmlspecialchars_decode($arItem['PREVIEW_TEXT'])?></div>
						<?if (isset($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'])):
							foreach($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'] as $key => $value):?>
								<a href="<?=$value['DETAIL_PAGE_URL']?>" class="interesting-row-sign"><?=$value['NAME']?></a>
							<?endforeach;
						endif;?>
                </div>
            </div>
			<?endforeach;?>
        </div>
    </section-->
<?endif?>