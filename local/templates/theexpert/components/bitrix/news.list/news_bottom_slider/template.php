<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if(count($arResult["ITEMS"])>0):?>
<?shuffle($arResult["ITEMS"]);?>
<div class="container">
    <div class="interesting-carousel carousel carousel-dark owl-carousel js-carousel-two">
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <div class="interesting-col">
                <div class="interesting-col-content">
                    <a href="" class="interesting-col-pic" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
                    </a>
                    <div class="h3 interesting-col-title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                    <div class="interesting-col-text"><?=htmlspecialchars_decode($arItem['PREVIEW_TEXT'])?></div>
                    <?if (isset($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'])):
                        foreach($arItem["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'] as $key => $value):?>
                            <a href="<?=$value['DETAIL_PAGE_URL']?>" class="interesting-col-sign"><?=$value['NAME']?></a>
                        <?endforeach;
                    endif;?>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
<?endif?>