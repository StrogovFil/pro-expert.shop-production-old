<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<section class="interesting interesting-light">
        <div class="container">
            <div class="h1 interesting-title">Другие статьи автора</div>
            <div class="interesting-carousel carousel carousel-dark owl-carousel js-carousel-two-nospace">
			<?foreach($arResult["ITEMS"] as $arItem):?>
                <div class="articles-item">
                    <a href="" class="articles-item-pic" style="background-image: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>');">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
                    </a>
                    <div class="h3 articles-item-title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                    <p><?=htmlspecialchars_decode($arItem['PREVIEW_TEXT'])?></p>
                        <?if (isset($arResult["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'])):
							foreach($arResult["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'] as $key => $value):?>
								<a href="<?=$value['DETAIL_PAGE_URL']?>" class="articles-item-sign"><?=$value['NAME']?></a>
							<?endforeach;
						endif;?>
                </div>
			<?endforeach;?>
            </div>
        </div>
    </section>
<?endif?>