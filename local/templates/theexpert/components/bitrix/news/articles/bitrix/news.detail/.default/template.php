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

if ($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"]))
	$backImage = "";
else
	$backImage = '';
?>
<?if ($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
        <div class="page-top" style="background-image: url(<?=$arResult["DETAIL_PICTURE"]["SRC"]?>);" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5" data-image-src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
		<?else:?>
		<div class="page-top">
		<?endif?>
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="<?=$arParams["FOLDER"] . $arParams["URL_TEMPLATES_NEWS"]?>">Все статьи</a></li>
                </ul>
				<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
					<h1 class="h1 page-top-title"><?=$arResult["NAME"]?></h1>
				<?endif;?>
            </div>
        </div>
        <div class="article">
			<div class="container">
                <div class="page-textblock">
                    <div class="container-inner article-decorated-1 article-avatar-wrap">
						<?if (isset($arResult["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'])):
							foreach($arResult["DISPLAY_PROPERTIES"]['DESIGNERS']['LINK_ELEMENT_VALUE'] as $key => $value):
								$pathPicture = CFile::GetPath($value['PREVIEW_PICTURE']);
								?>
								<a class="article-avatar" href="<?=$value['DETAIL_PAGE_URL']?>">
									<span class="article-avatar-pic" style="background-image: url('<?=$pathPicture?>');">
										<img src="<?=$pathPicture?>" alt="">
									</span>
									<span class="article-avatar-title"><?=$value['NAME']?></span>								
								</a>
							<?endforeach;
						endif;?>
                        <?if ($arResult["PREVIEW_TEXT"])
							echo $arResult["PREVIEW_TEXT"];?>
                    </div>
                </div>
            </div><?if (isset($arResult["PROPERTIES"]['MORE_PHOTO']) && !empty($arResult["PROPERTIES"]['MORE_PHOTO']['VALUE'])):?>
            <div class="carousel-auto-wrap about-carousel">
                <div class="carousel-auto-wrap-inner">
                    <div class="carousel-auto owl-carousel js-carousel-auto">
						<?foreach($arResult["PROPERTIES"]['MORE_PHOTO']['VALUE'] as $imageId):
						$pathPicture = CFile::GetPath($imageId);
						?>
                        <a href="<?=$pathPicture?>" class="carousel-auto-item" data-fancybox="carousel">
                            <img src="<?=$pathPicture?>" alt="">
                            <span class="carousel-auto-item-mask"></span>
                        </a>
						<?endforeach?>
                    </div>
                </div>
            </div>
			<?endif;?>
			<div class="container">
                <div class="page-textblock">
                    <div class="container-inner">
                        <?=htmlspecialchars_decode($arResult['DETAIL_TEXT'])?>
                    </div>
                </div>
            </div>
        </div>