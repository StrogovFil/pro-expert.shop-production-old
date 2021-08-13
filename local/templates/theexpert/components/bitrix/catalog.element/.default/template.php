<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');


$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
    $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
        ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
        : reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] > 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}
$gallery = false;
$arIBTYPE = CIBlockType::GetByIDLang("catalog", LANGUAGE_ID);
if ($arIBTYPE !== false) {
    $arFilter = Array('IBLOCK_ID' => $arResult["ORIGINAL_PARAMETERS"]["IBLOCK_ID"]);
    $db_list = CIBlockSection::GetList(Array(), $arFilter, true, array("*", "UF_*"));
    while ($ar_result = $db_list->GetNext()) {
        if($ar_result['CODE'] == "kollektsiya" && $actualItem["SECTION_CODE"] == $ar_result['CODE']){
            $gallery = $ar_result['UF_GALLERY'];
        }
    }
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$iStoreId = 0;
$strBuyDesc = '';
$strDeliveryStatus = '';
$arStores = array();

$obStore = CCatalogStoreProduct::GetList(
    array(),
    array('PRODUCT_ID' => $arResult['ID']),
    false,
    false,
    array()
);

while ($arStore = $obStore->Fetch())
{
    if ($arStore['AMOUNT'])
    {
        if (($iStoreId && $arStore['STORE_ID'] < $iStoreId) || !$iStoreId)
        {
            $iStoreId = $arStore['STORE_ID'];
            $strBuyDesc = $arStore['STORE_NAME'];

            if ($iStoreId > 1)
                $strDeliveryStatus = GetMessage('CT_BCE_CATALOG_DELIVERY_TIME');
            else
                $strDeliveryStatus = 'На складе';
        }

        $arStores[] = $arStore;
    }
}

?>

<?/*
global $USER;
if ($USER->IsAdmin()){
    ?><pre><?print_r($actualItem['MORE_PHOTO']);?></pre><?
}*/
?>




    <div class="product-top" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product">
        <div class="container box-detail">
            <div class="product-top-images">
                <div class="product-top-images-inner">
                    <div class="product-top-images-main">
                        <div id="galleryMain" class="owl-carousel">
                            <?
                            if($gallery){
                                foreach ($gallery as $key => $v)
                                {
                                    ?>
                                    <a href="<?=CFile::GetPath($v)?>" class="carousel-auto-item" data-fancybox="carousel" >
                                        <?/*<img src="<?=CFile::GetPath($v)?>">*/?>
                                        <div class="carousel-auto-item__img-bg" style="background-image: url(<?=CFile::GetPath($v)?>);"></div>
                                    </a>
                                    <?
                                }
                            }
                            elseif (!empty($actualItem['MORE_PHOTO']))
                            {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                {
                                    ?>
                                    <a href="<?=$photo['SRC']?>" class="carousel-auto-item" data-fancybox="carousel" >
                                        <?/*<img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>">*/?>
                                        <div class="carousel-auto-item__img-bg" style="background-image: url(<?=$photo['SRC']?>);"></div>
                                    </a>
                                    <?
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="product-top-images-thumb">
                        <div id="galleryThumbs" class="owl-carousel">
                            <?if($gallery){
                                foreach ($gallery as $key => $v)
                                {
                                    ?>
                                    <img src="<?=CFile::GetPath($v)?>">
                                    <?
                                }
                            }
                            elseif  (!empty($actualItem['MORE_PHOTO']))
                            {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                {
                                    ?>
                                    <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>">
                                    <?
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>" style="display: none">
                <span class="product-item-detail-slider-close" data-entity="close-popup"></span>
                <div class="product-item-detail-slider-block
						<?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
                     data-entity="images-slider-block">
                    <span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
                    <span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
                    <div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>"
                        <?=(!$arResult['LABEL'] ? 'style="display: none;"' : '' )?>>
                        <?
                        if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE']))
                        {
                            foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value)
                            {
                                ?>
                                <div<?=(!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
                                    <span title="<?=$value?>"><?=$value?></span>
                                </div>
                                <?
                            }
                        }
                        ?>
                    </div>
                    <?
                    if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
                    {
                        if ($haveOffers)
                        {
                            ?>
                            <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                 style="display: none;">
                            </div>
                            <?
                        }
                        else
                        {
                            if ($price['DISCOUNT'] > 0)
                            {
                                ?>
                                <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
                                     title="<?=-$price['PERCENT']?>%">
                                    <span><?=-$price['PERCENT']?>%</span>
                                </div>
                                <?
                            }
                        }
                    }
                    ?>
                    <div class="product-item-detail-slider-images-container" data-entity="images-container">
                        <?
                        if (!empty($actualItem['MORE_PHOTO']))
                        {
                            foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                            {
                                ?>
                                <div class="product-item-detail-slider-image<?=($key == 0 ? ' active' : '')?>" data-entity="image" data-id="<?=$photo['ID']?>">
                                    <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
                                </div>
                                <?
                            }
                        }

                        if ($arParams['SLIDER_PROGRESS'] === 'Y')
                        {
                            ?>
                            <div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <?
                if ($showSliderControls)
                {
                    if ($haveOffers)
                    {
                        foreach ($arResult['OFFERS'] as $keyOffer => $offer)
                        {
                            if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
                                continue;

                            $strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
                            ?>
                            <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
                                <?
                                foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
                                {
                                    ?>
                                    <div class="product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
                                         data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
                                        <img src="<?=$photo['SRC']?>">
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                        }
                    }
                    else
                    {
                        ?>
                        <div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_ID']?>">
                            <?
                            if (!empty($actualItem['MORE_PHOTO']))
                            {
                                foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
                                {
                                    ?>
                                    <div class="product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
                                         data-entity="slider-control" data-value="<?=$photo['ID']?>">
                                        <img src="<?=$photo['SRC']?>">
                                    </div>
                                    <?
                                }
                            }
                            ?>
                        </div>
                        <?
                    }
                }
                ?>
            </div>
            <div class="product-top-content">
                <?
                if ($arParams['DISPLAY_NAME'] === 'Y')
                {
                    ?>
                    <h1 class="h3 product-top-title"><?=$name?></h1>
                    <?
                }
                ?>
                <div class="product-top-text">
                    <?=htmlspecialchars_decode($actualItem['PREVIEW_TEXT'])?>
                </div>

                <table class="product-accordion-properties q1">
                    <? $arNeedProperties = array('BRAND','COUNTRIES','DESIGNERS');

                    foreach($actualItem['DISPLAY_PROPERTIES'] as $arProperty)
                    {
                        if (in_array($arProperty['CODE'], $arNeedProperties))
                        { ?>
                            <tr>
                                <td><b><?=$arProperty['NAME']?>:</b></td>
                                <td>
                                    <? if (is_array($arProperty['DISPLAY_VALUE']))
                                    {
                                        foreach($arProperty['DISPLAY_VALUE'] as $key => $strPropertyValue)
                                        {
                                            if ($key) echo ', ';

                                            echo $strPropertyValue;
                                        }
                                    }
                                    else
                                    {
                                        echo '&nbsp',$arProperty['DISPLAY_VALUE'];
                                    } ?>
                                </td>
                            </tr>
                            <? //echo '<pre>';print_r($arProperty); echo '</pre>';
                        }
                    }

                    //print_r($actualItem['DISPLAY_PROPERTIES']); ?>
                    <!--?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['CHARACTERISTIC']['VALUE']['TEXT'])?-->
                    <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES'])?>
                </table>

                <div class="container22">
                    <?if ($actualItem['DISPLAY_PROPERTIES']['DESCRIPTION_2']['VALUE']['TEXT']):?>
                        <div class="product-text22 container-inner22">
                            <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['DESCRIPTION_2']['VALUE']['TEXT'])?>
                        </div>
                    <?endif?>
                    <div class="product-accordion22">
                        <!-- <div class="accordion js-accordion" data-single="true"> -->
                        <div class="accordion">
                            <!-- Если не указывать data-single, пункты будут раскрываться, не закрывая другие. Если указать, при раскрытии одного пунтка другие автоматически закроются -->
                            <div class="accordion-row">
                                <div class="accordion-row-header">
                                    <div class="accordion-row-title"><span>Характеристики</span> <!-- <i class="icon icon-dropdown"></i> --></div>
                                </div>
                                <div class="accordion-row-body">
                                    <table class="product-accordion-properties q2">
                                        <? $arNeedProperties = array('CHARACTERISTIC', 'SIZE_Y', 'SIZE_X', 'SIZE_Z', 'SIZE_O', 'DIA', 'MATERIALS', 'COVER', 'FRAME', 'CTOPS', 'RIM', 'PILLAR', 'VOLTAGE', 'POWER', 'LUMEN', 'TEMPERATURE', 'RIPPLE', 'FIXATION', 'LENS', 'PROTECTION', 'COLOR', 'STYLE','OPTION');

                                        foreach($actualItem['DISPLAY_PROPERTIES'] as $arProperty)
                                        {
                                            if (in_array($arProperty['CODE'], $arNeedProperties))
                                            { ?>
                                                <tr>
                                                    <td><?=$arProperty['NAME']?>:</td>
                                                    <td>
                                                        <? if (is_array($arProperty['DISPLAY_VALUE']))
                                                        {
                                                            foreach($arProperty['DISPLAY_VALUE'] as $key => $strPropertyValue)
                                                            {
                                                                if ($key) echo ', ';

                                                                echo $strPropertyValue;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo $arProperty['DISPLAY_VALUE'];
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <? //echo '<pre>';print_r($arProperty); echo '</pre>';
                                            }
                                        }

                                        //print_r($actualItem['DISPLAY_PROPERTIES']); ?>
                                        <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['CHARACTERISTIC']['VALUE']['TEXT'])?>
                                    </table>
                                </div>
                            </div>
                            <?if($actualItem['PROPERTIES']['CHECK_USAGE']['VALUE']){?>
                                <div class="accordion-row">
                                    <div class="accordion-row-header">
                                        <a href="javascript:" class="accordion-row-title"><span>Применение</span> <i class="icon icon-dropdown"></i></a>
                                    </div>
                                    <div class="accordion-row-body">
                                        <?//=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['USED']['VALUE']['TEXT'])?>
                                        <?if(is_array($actualItem['DISPLAY_PROPERTIES']['FUNCTIONAL']['DISPLAY_VALUE'])):
                                            foreach($actualItem['DISPLAY_PROPERTIES']['FUNCTIONAL']['DISPLAY_VALUE'] as $func_arr):
                                                echo $func_arr?><br><?;
                                            endforeach;
                                        else:
                                            echo $actualItem['DISPLAY_PROPERTIES']['FUNCTIONAL']['DISPLAY_VALUE'];
                                        endif;?>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>


                <div class="product-form" style="display: flex;justify-content: center">
                    <div class="product-form-top" style="display: none">
                        <div class="product-form-price">
                            <?
                            if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                            {
                                ?>
                                <span class="product-item-detail-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>"
                                      style="display: <?=($showDiscount ? '' : 'none')?>;">
										<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
									</span>
                                <?
                            }
                            ?>
                            <span class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>">
									<?=$price['PRINT_RATIO_PRICE']?>
								</span>
                            <?
                            if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                            {
                                ?>
                                <span class="item_economy_price" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>"
                                      style="display: <?=($showDiscount ? '' : 'none')?>;">
										<?
                                        if ($showDiscount)
                                        {
                                            echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
                                        }
                                        ?>
									</span>
                                <?
                            }
                            ?>
                        </div>
                        <?if ($arParams['USE_PRODUCT_QUANTITY'])
                        {
                            ?>
                            <div class="product-form-count" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
                                 data-entity="quantity-block">
                                <div class="product-item-amount">
                                    <div class="product-item-amount-field-container">
											<span class="product-form-count-btn" id="<?=$itemIds['QUANTITY_DOWN_ID']?>">
												<i class="icon icon-angle-left"></i>
											</span>
                                        <input class="product-form-count-input" id="<?=$itemIds['QUANTITY_ID']?>" type="number"
                                               value="<?=$price['MIN_QUANTITY']?>">
                                        <span class="product-form-count-btn" id="<?=$itemIds['QUANTITY_UP_ID']?>">
												<i class="icon icon-angle-right"></i>
											</span>
                                        <span class="product-item-amount-description-container" style="display: none">
												<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
													<?=$actualItem['ITEM_MEASURE']['TITLE']?>
												</span>
												<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
											</span>
                                    </div>
                                </div>
                            </div>
                            <?
                        }?>
                    </div>
                    <div data-entity="main-button-container">
                        <div class="product-form-bottom" id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                            <span class="product-form-buy-from"><?=$strBuyDesc?></span>
                            <?
                            if ($showAddBtn)
                            {
                                ?>
                                <a class="product-form-buy btn" id="<?=$itemIds['ADD_BASKET_LINK']?>"
                                   href="javascript:void(0);">
                                    <span>Заказать</span>
<!--                                    <span>--><?//=$arParams['MESS_BTN_ADD_TO_BASKET']?><!--</span>-->
                                </a>
                                <?
                            }

                            if ($showBuyBtn)
                            {
                                ?>
                                <a class="product-form-buy btn" id="<?=$itemIds['BUY_LINK']?>"
                                   href="javascript:void(0);">
                                    <i class="icon icon-bag"></i>
                                    <span><?=$arParams['MESS_BTN_BUY']?></span>
                                </a>
                                <?
                            }
                            ?>
                            <?/*
                            <a href="/dostavka-i-oplata/" class="product-form-help">
                                <span><?=$strDeliveryStatus?></span> <i class="icon icon-warning"></i>
                                <div class="product-form-help-informer"><?=GetMessage('CT_BCE_CATALOG_HELP_INFORMER')?></div>
                            </a>
                            */?>
                        </div>
                        <?
                        if ($showSubscribe)
                        {
                            ?>
                            <div class="product-item-detail-info-container">
                                <?
                                $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.product.subscribe',
                                    '',
                                    array(
                                        'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                        'PRODUCT_ID' => $arResult['ID'],
                                        'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                        'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                                        'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
                            </div>
                            <?
                        }
                        ?>
                        <div class="product-item-detail-info-container">
                            <a class="btn btn-link product-item-detail-buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
                               href="javascript:void(0)"
                               rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                <?=$arParams['MESS_NOT_AVAILABLE']?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?if ($actualItem['DETAIL_TEXT']):?>
    <div class="product-middle middle-box">
        <div class="container">
            <div class="product-text container-inner">
                <?=htmlspecialchars_decode($actualItem['DETAIL_TEXT'])?>
            </div>
        </div>
    </div>
<?endif?>
<?if (!empty($actualItem['PROPERTIES']['MORE_PHOTO_2']['VALUE'])):?>
    <div class="h1 h1-center">Коллекция в деталях</div>
    <div class="container">
        <div class="owl-carousel owl-carousel-def js-carousel-def">
            <?foreach($actualItem['PROPERTIES']['MORE_PHOTO_2']['VALUE'] as $key => $photo):
                $imagePath = CFile::GetPath($photo);
                ?>
                <a href="<?=$imagePath?>" class="carousel-auto-item" data-fancybox="carousel237">
                    <!-- <img src="<?=$imagePath?>" alt=""> -->
                    <div style="background-image: url('<?=$imagePath?>');" class="owl-carousel-def__img"></div>
                    <span class="carousel-auto-item-mask"></span>
                </a>
            <?endforeach?>
        </div>
    </div>
<?endif?>
<?if (count($actualItem['PROPERTIES']['MORE_PHOTO_2']['VALUE'])===222):?>
    <div class="product-bottom">
        <div class="container">
            <?if ($actualItem['DISPLAY_PROPERTIES']['DESCRIPTION_2']['VALUE']['TEXT']):?>
                <div class="product-text container-inner">
                    <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['DESCRIPTION_2']['VALUE']['TEXT'])?>
                </div>
            <?endif?>
            <div class="product-accordion">
                <!-- <div class="accordion js-accordion" data-single="true"> -->
                <div class="accordion">
                    <!-- Если не указывать data-single, пункты будут раскрываться, не закрывая другие. Если указать, при раскрытии одного пунтка другие автоматически закроются -->
                    <div class="accordion-row">
                        <div class="accordion-row-header">
                            <div class="accordion-row-title"><span>Характеристики</span> <!-- <i class="icon icon-dropdown"></i> --></div>
                        </div>
                        <div class="accordion-row-body">
                            <table class="product-accordion-properties q3">
                                <? $arNeedProperties = array('CHARACTERISTIC', 'SIZE_Y', 'SIZE_X', 'SIZE_Z', 'SIZE_O', 'DIA', 'MATERIALS', 'COVER', 'FRAME', 'CTOPS', 'RIM', 'PILLAR', 'VOLTAGE', 'POWER', 'LUMEN', 'TEMPERATURE', 'RIPPLE', 'FIXATION', 'LENS', 'PROTECTION', 'COLOR', 'STYLE','OPTION');

                                foreach($actualItem['DISPLAY_PROPERTIES'] as $arProperty)
                                {
                                    if (in_array($arProperty['CODE'], $arNeedProperties))
                                    { ?>
                                        <tr>
                                            <td><?=$arProperty['NAME']?>:</td>
                                            <td>
                                                <? if (is_array($arProperty['DISPLAY_VALUE']))
                                                {
                                                    foreach($arProperty['DISPLAY_VALUE'] as $key => $strPropertyValue)
                                                    {
                                                        if ($key) echo ', ';

                                                        echo $strPropertyValue;
                                                    }
                                                }
                                                else
                                                {
                                                    echo $arProperty['DISPLAY_VALUE'];
                                                } ?>
                                            </td>
                                        </tr>
                                        <? //echo '<pre>';print_r($arProperty); echo '</pre>';
                                    }
                                }

                                //print_r($actualItem['DISPLAY_PROPERTIES']); ?>
                                <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['CHARACTERISTIC']['VALUE']['TEXT'])?>
                            </table>
                        </div>
                    </div>
                    <div class="accordion-row">
                        <div class="accordion-row-header">
                            <a href="javascript:" class="accordion-row-title"><span>Применения</span> <i class="icon icon-dropdown"></i></a>
                        </div>
                        <div class="accordion-row-body">
                            <?=htmlspecialchars_decode($actualItem['DISPLAY_PROPERTIES']['USED']['VALUE']['TEXT'])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?endif?>

        <meta itemprop="name" content="<?=$name?>" />
        <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
        <?
        if ($haveOffers)
        {
            foreach ($arResult['JS_OFFERS'] as $offer)
            {
                $currentOffersList = array();

                if (!empty($offer['TREE']) && is_array($offer['TREE']))
                {
                    foreach ($offer['TREE'] as $propName => $skuId)
                    {
                        $propId = (int)substr($propName, 5);

                        foreach ($skuProps as $prop)
                        {
                            if ($prop['ID'] == $propId)
                            {
                                foreach ($prop['VALUES'] as $propId => $propValue)
                                {
                                    if ($propId == $skuId)
                                    {
                                        $currentOffersList[] = $propValue['NAME'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
				<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
				<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
				<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
			</span>
                <?
            }

            unset($offerPrice, $currentOffersList);
        }
        else
        {
            ?>
            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
            <?
        }
        ?>
    </div>
<? if ($haveOffers)
{
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
    {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS'])
        {
            if (!empty($jsOffer['DISPLAY_PROPERTIES']))
            {
                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
                {
                    $current = '<dt>'.$property['NAME'].'</dt><dd>'.(
                        is_array($property['VALUE'])
                            ? implode(' / ', $property['VALUE'])
                            : $property['VALUE']
                        ).'</dd>';
                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
                    {
                        $strMainProps .= $current;
                    }
                }

                unset($current);
            }
        }

        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
        {
            $strPriceRangesRatio = '('.Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ).' '.$measureName)
                ).')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
            {
                if ($range['HASH'] !== 'ZERO-INF')
                {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
                    {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                        {
                            break;
                        }
                    }

                    if ($itemPrice)
                    {
                        $strPriceRanges .= '<dt>'.Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
                            ).' ';

                        if (is_infinite($range['SORT_TO']))
                        {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        }
                        else
                        {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'].' '.$measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps
    );
}
else
{
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
    {
        ?>
        <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
            <?
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
            {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
                {
                    ?>
                    <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                    <?
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties)
            {
                ?>
                <table>
                    <?
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
                    {
                        ?>
                        <tr>
                            <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
                            <td>
                                <?
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                )
                                {
                                    foreach ($propInfo['VALUES'] as $valueId => $value)
                                    {
                                        ?>
                                        <label>
                                            <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                                                   value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
                                            <?=$value?>
                                        </label>
                                        <br>
                                        <?
                                    }
                                }
                                else
                                {
                                    ?>
                                    <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
                                        <?
                                        foreach ($propInfo['VALUES'] as $valueId => $value)
                                        {
                                            ?>
                                            <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
                                                <?=$value?>
                                            </option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                    }
                    ?>
                </table>
                <?
            }
            ?>
        </div>
        <?
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => "N",//$arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}
?>
    <script>
        BX.message({
            ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
            TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
            TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
            BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
            BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
            BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
            BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
            BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
            TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
            COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
            COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
            COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
            BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
            PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
            PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
            RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
            RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
            SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
        });

        var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
    </script>
<?
unset($actualItem, $itemIds, $jsParams);
