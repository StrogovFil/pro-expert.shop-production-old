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
//print_r($arParams['CATALOG_PARAMS']);
global $arrFilter;
$propName = '';
$arProducts = array();
$arNotInclude = array();

$dir = $APPLICATION->GetCurDir();

	if (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'price'){
		$arParams['CATALOG_PARAMS']['ELEMENT_SORT_FIELD'] = 'catalog_PRICE_1';
	}elseif (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'name') {
		$arParams['CATALOG_PARAMS']['ELEMENT_SORT_FIELD'] = 'name';
	}elseif (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'id') {
		$arParams['CATALOG_PARAMS']['ELEMENT_SORT_FIELD'] = 'id';
	}

if (isset($_REQUEST['order']))
{
	if ($_REQUEST['order'] == 'DESC')
		$strOrder = 'ASC';
	else
		$strOrder = 'DESC';

	$arParams['CATALOG_PARAMS']["ELEMENT_SORT_ORDER"] = $_REQUEST['order'];
}
else
	$strOrder = 'ASC';

switch($arResult['IBLOCK_CODE'])
{
	case 'place':
		$arrFilter['PROPERTY_APARTMENT'] = $arResult['ID'];
		if($_GET['sectionId'])
        {
            $arrFilter['SECTION_ID'] = $_GET['sectionId'];
            $arrFilter['INCLUDE_SUBSECTIONS'] = 'Y';
        }
		$propName = 'PROPERTY_APARTMENT';
		$arNotInclude[] = 'APARTMENT';
		break;
	case 'brands':
		$arrFilter['PROPERTY_27'] = $arResult['ID'];
		if($_GET['sectionId'])
        {
            $arrFilter['SECTION_ID'] = $_GET['sectionId'];
            $arrFilter['INCLUDE_SUBSECTIONS'] = 'Y';
        }
		$propName = 'PROPERTY_BRAND';
		$arNotInclude[] = 'BRAND';
		break;
}
$obProducts = CIBlockElement::GetList(
	array(),
	array(
		'IBLOCK_ID' => $arParams['CATALOG_PARAMS']['IBLOCK_ID'],
		$propName => $arResult["ID"]
	),
	false,
	false,
	array('ID', 'IBLOCK_ID', 'NAME', 'IBLOCK_SECTION_ID')
);

while($arProduct = $obProducts->Fetch())
{
	$arProductSection = array('DEPTH_LEVEL' => 2, 'IBLOCK_SECTION_ID' => $arProduct['IBLOCK_SECTION_ID']);

	while($arProductSection['DEPTH_LEVEL'] != 1)
	{
		$obProductSection = CIBlockSection::GetByID($arProductSection['IBLOCK_SECTION_ID']);
		$arProductSection = $obProductSection->GetNext();
	}

	$arProductSections[$arProductSection['ID']] = $arProductSection;
	$arProducts[] = $arProduct;
}

if (isset($arParams['CATALOG_PARAMS']['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['CATALOG_PARAMS']['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset($arParams['CATALOG_PARAMS']['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['CATALOG_PARAMS']['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
	$basketAction = isset($arParams['CATALOG_PARAMS']['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['CATALOG_PARAMS']['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

$curDurId = '';
if(strstr($dir, 'brand-') === false) {
    $curDurId = $arResult['ID'];
} else {
    $curDurId = '';
}
?>

	<section class="page catalog">
		<div class="topblock catalog-top">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="topblock-pic" style="background-image: url('<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
				<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>" onerror="this.onerror = null; this.src = '<?=$arResult["DETAIL_PICTURE"]["SRC"]?>'" />
			</div>
			<?else:?>
			<div class="topblock-pic"></div>
			<?endif?>
			<div class="topblock-content">
				<div class="topblock-content-inner">
					<div class="topblock-header topblock-header-graphic">
						<div class="h3 topblock-title"><?=$arResult['NAME']?></div>
						<?/*if ($arResult['PROPERTIES']['PRODUCTS']['VALUE']){?>
							<div class="topblock-header-note">Всего <?=count($arResult['PROPERTIES']['PRODUCTS']['VALUE']);?></div>
						<?}*/?>
					</div>
					<div class="topblock-text"><?=$arResult['DETAIL_TEXT']?></div>
					<hr>
					<?/*if (!empty($arProductSections)):?>
					<ul class="topblock-menu">
						<?foreach($arProductSections as $arProductSection):?>
						<li>
							<a href="<?=$arProductSection['SECTION_PAGE_URL']?>"><?=$arProductSection['NAME']?></a>
						</li>
						<?endforeach?>
					</ul>
					<?endif*/?>

					<?if ($arResult['PROPERTIES']['PRODUCTS']['VALUE']):?>
					<ul class="topblock-menu">
						<?foreach($arResult['PROPERTIES']['PRODUCTS']['VALUE'] as $arSec):?>
						<?$el_res = CIBlockSection::GetList(array(), array('ID'=>$arSec), false, false, array('NAME', 'SECTION_PAGE_URL'));
						if ($el_arr= $el_res->GetNext()) {?>
							<li>
								<a href="<?=$el_arr['SECTION_PAGE_URL'];?>"><?=$el_arr['NAME']?></a>
							</li>
						<?}?>
						<?endforeach?>
					</ul>
					<?endif?>
				</div>
			</div>
		</div>
		<div class="catalog-items-bordered container catalog-container-page">
			<? if ($arParams['CATALOG_PARAMS']['USE_FILTER'] == 'Y'): ?>
			<div class="filters catalog-filters">
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.smart.filter",
					"bootstrap_v4",
					array(
						"IBLOCK_TYPE" => $arParams['CATALOG_PARAMS']["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams['CATALOG_PARAMS']["IBLOCK_ID"],
						"SECTION_ID" => $arCurSection['ID'],
						"FILTER_NAME" => $arParams['CATALOG_PARAMS']["FILTER_NAME"],
						"PRICE_CODE" => '',//$arParams['CATALOG_PARAMS']["~PRICE_CODE"],
						"CACHE_TYPE" => $arParams['CATALOG_PARAMS']["CACHE_TYPE"],
						"CACHE_TIME" => $arParams['CATALOG_PARAMS']["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams['CATALOG_PARAMS']["CACHE_GROUPS"],
						"SAVE_IN_SESSION" => "N",
						"FILTER_VIEW_MODE" => $arParams['CATALOG_PARAMS']["FILTER_VIEW_MODE"],
						"XML_EXPORT" => "N",
						"SECTION_TITLE" => "NAME",
						"SECTION_DESCRIPTION" => "DESCRIPTION",
						'HIDE_NOT_AVAILABLE' => $arParams['CATALOG_PARAMS']["HIDE_NOT_AVAILABLE"],
						"TEMPLATE_THEME" => $arParams['CATALOG_PARAMS']["TEMPLATE_THEME"],
						'CONVERT_CURRENCY' => $arParams['CATALOG_PARAMS']['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CATALOG_PARAMS']['CURRENCY_ID'],
						//"SEF_MODE" => 'N',//$arParams['CATALOG_PARAMS']["SEF_MODE"],
						//"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
						//"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
						//"PAGER_PARAMS_NAME" => $arParams['CATALOG_PARAMS']["PAGER_PARAMS_NAME"],
						"INSTANT_RELOAD" => $arParams['CATALOG_PARAMS']["INSTANT_RELOAD"],
						'NOT_INCLUDE' => $arNotInclude,
                        'FILTER_SECTION' => true,
						'FILTER_TYPE' => $arParams['FILTER_TYPE'],
                        'SECTION_FILTER_ID' => $curDurId
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
				?>
                <div class="filters-sort">
                    Сортировать:&emsp;
                    <?if($_REQUEST['order'] == ''):?>
                        <a href="?sort=name&order=DESC" class="filter-sort-ASC filter-sort-item filter-sort-active">A - Z <i class="icon icon-dropdown"></i></a>
                    <?elseif($strOrder == 'ASC'):?>
                        <a href="?sort=name&order=ASC" class="filter-sort-DESC filter-sort-item filter-sort-active">Z - A <i class="icon icon-dropdown"></i></a>
                    <?elseif($strOrder == 'DESC'):?>
                        <a href="?sort=name&order=DESC" class="filter-sort-ASC filter-sort-item filter-sort-active">A - Z <i class="icon icon-dropdown"></i></a>
                    <?endif?>
                    <?/*<a href="?sort=id&order=<?=$strOrder?>" class="filter-sort-<?=$strOrder?> filter-sort-item <?if($_REQUEST['sort'] == 'id'){?>filter-sort-active<?}?>">по новизне <i class="icon icon-dropdown"></i></a>*/?>
                    <?/*<a href="?sort=price&order=<?=$strOrder?>" class="filter-sort-<?=$strOrder?> filter-sort-item <?if($_REQUEST['sort'] == 'price'){?>filter-sort-active<?}?>">по цене <i class="icon icon-dropdown"></i></a>*/?>
                </div>
			</div>
		<? endif ?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"",
				array(
					"IBLOCK_TYPE" => $arParams['CATALOG_PARAMS']["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams['CATALOG_PARAMS']["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams['CATALOG_PARAMS']["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams['CATALOG_PARAMS']["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams['CATALOG_PARAMS']["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams['CATALOG_PARAMS']["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams['CATALOG_PARAMS']["LIST_PROPERTY_CODE"],
					"PROPERTY_CODE_MOBILE" => $arParams['CATALOG_PARAMS']["LIST_PROPERTY_CODE_MOBILE"],
					"META_KEYWORDS" => $arParams['CATALOG_PARAMS']["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams['CATALOG_PARAMS']["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams['CATALOG_PARAMS']["LIST_BROWSER_TITLE"],
					"SET_LAST_MODIFIED" => $arParams['CATALOG_PARAMS']["SET_LAST_MODIFIED"],
					"INCLUDE_SUBSECTIONS" => $arParams['CATALOG_PARAMS']["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams['CATALOG_PARAMS']["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams['CATALOG_PARAMS']["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams['CATALOG_PARAMS']["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams['CATALOG_PARAMS']["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams['CATALOG_PARAMS']["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams['CATALOG_PARAMS']["PRODUCT_PROPS_VARIABLE"],
					"FILTER_NAME" => $arParams['CATALOG_PARAMS']["FILTER_NAME"],
					"CACHE_TYPE" => $arParams['CATALOG_PARAMS']["CACHE_TYPE"],
					"CACHE_TIME" => $arParams['CATALOG_PARAMS']["CACHE_TIME"],
					"CACHE_FILTER" => $arParams['CATALOG_PARAMS']["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams['CATALOG_PARAMS']["CACHE_GROUPS"],
					"SET_TITLE" => $arParams['CATALOG_PARAMS']["SET_TITLE"],
					"MESSAGE_404" => $arParams['CATALOG_PARAMS']["~MESSAGE_404"],
					"SET_STATUS_404" => $arParams['CATALOG_PARAMS']["SET_STATUS_404"],
					"SHOW_404" => $arParams['CATALOG_PARAMS']["SHOW_404"],
					"FILE_404" => $arParams['CATALOG_PARAMS']["FILE_404"],
					"DISPLAY_COMPARE" => $arParams['CATALOG_PARAMS']["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams['CATALOG_PARAMS']["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams['CATALOG_PARAMS']["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams['CATALOG_PARAMS']["~PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams['CATALOG_PARAMS']["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams['CATALOG_PARAMS']["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams['CATALOG_PARAMS']["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['CATALOG_PARAMS']['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams['CATALOG_PARAMS']["ADD_PROPERTIES_TO_BASKET"]) ? $arParams['CATALOG_PARAMS']["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams['CATALOG_PARAMS']["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams['CATALOG_PARAMS']["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams['CATALOG_PARAMS']["PRODUCT_PROPERTIES"],

					"DISPLAY_TOP_PAGER" => $arParams['CATALOG_PARAMS']["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams['CATALOG_PARAMS']["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams['CATALOG_PARAMS']["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams['CATALOG_PARAMS']["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams['CATALOG_PARAMS']["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams['CATALOG_PARAMS']["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams['CATALOG_PARAMS']["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams['CATALOG_PARAMS']["PAGER_SHOW_ALL"],
					"PAGER_BASE_LINK_ENABLE" => $arParams['CATALOG_PARAMS']["PAGER_BASE_LINK_ENABLE"],
					"PAGER_BASE_LINK" => $arParams['CATALOG_PARAMS']["PAGER_BASE_LINK"],
					"PAGER_PARAMS_NAME" => $arParams['CATALOG_PARAMS']["PAGER_PARAMS_NAME"],
					"LAZY_LOAD" => $arParams['CATALOG_PARAMS']["LAZY_LOAD"],
					"MESS_BTN_LAZY_LOAD" => $arParams['CATALOG_PARAMS']["~MESS_BTN_LAZY_LOAD"],
					"LOAD_ON_SCROLL" => $arParams['CATALOG_PARAMS']["LOAD_ON_SCROLL"],

					"OFFERS_CART_PROPERTIES" => $arParams['CATALOG_PARAMS']["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams['CATALOG_PARAMS']["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams['CATALOG_PARAMS']["LIST_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams['CATALOG_PARAMS']["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams['CATALOG_PARAMS']["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams['CATALOG_PARAMS']["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams['CATALOG_PARAMS']["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams['CATALOG_PARAMS']["LIST_OFFERS_LIMIT"],

					"SECTION_ID" => '',
					"SECTION_CODE" => '',
					"SECTION_URL" => $arParams['CATALOG_PARAMS']["SEF_FOLDER"].$arParams['CATALOG_PARAMS']["SEF_URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arParams['CATALOG_PARAMS']["SEF_FOLDER"].$arParams['CATALOG_PARAMS']["SEF_URL_TEMPLATES"]["element"],
					"USE_MAIN_ELEMENT_SECTION" => $arParams['CATALOG_PARAMS']["USE_MAIN_ELEMENT_SECTION"],
					'CONVERT_CURRENCY' => $arParams['CATALOG_PARAMS']['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CATALOG_PARAMS']['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams['CATALOG_PARAMS']["HIDE_NOT_AVAILABLE"],
					'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['CATALOG_PARAMS']["HIDE_NOT_AVAILABLE_OFFERS"],
					'HIDE_SECTION_DESCRIPTION' => 'Y',

					'LABEL_PROP' => $arParams['CATALOG_PARAMS']['LABEL_PROP'],
					'LABEL_PROP_MOBILE' => $arParams['CATALOG_PARAMS']['LABEL_PROP_MOBILE'],
					'LABEL_PROP_POSITION' => $arParams['CATALOG_PARAMS']['LABEL_PROP_POSITION'],
					'ADD_PICT_PROP' => $arParams['CATALOG_PARAMS']['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['CATALOG_PARAMS']['PRODUCT_DISPLAY_MODE'],
					'PRODUCT_BLOCKS_ORDER' => $arParams['CATALOG_PARAMS']['LIST_PRODUCT_BLOCKS_ORDER'],
					'PRODUCT_ROW_VARIANTS' => $arParams['CATALOG_PARAMS']['LIST_PRODUCT_ROW_VARIANTS'],
					'ENLARGE_PRODUCT' => $arParams['CATALOG_PARAMS']['LIST_ENLARGE_PRODUCT'],
					'ENLARGE_PROP' => isset($arParams['CATALOG_PARAMS']['LIST_ENLARGE_PROP']) ? $arParams['CATALOG_PARAMS']['LIST_ENLARGE_PROP'] : '',
					'SHOW_SLIDER' => $arParams['CATALOG_PARAMS']['LIST_SHOW_SLIDER'],
					'SLIDER_INTERVAL' => isset($arParams['CATALOG_PARAMS']['LIST_SLIDER_INTERVAL']) ? $arParams['CATALOG_PARAMS']['LIST_SLIDER_INTERVAL'] : '',
					'SLIDER_PROGRESS' => isset($arParams['CATALOG_PARAMS']['LIST_SLIDER_PROGRESS']) ? $arParams['CATALOG_PARAMS']['LIST_SLIDER_PROGRESS'] : '',

					'OFFER_ADD_PICT_PROP' => $arParams['CATALOG_PARAMS']['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['CATALOG_PARAMS']['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['CATALOG_PARAMS']['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['CATALOG_PARAMS']['SHOW_DISCOUNT_PERCENT'],
					'DISCOUNT_PERCENT_POSITION' => $arParams['CATALOG_PARAMS']['DISCOUNT_PERCENT_POSITION'],
					'SHOW_OLD_PRICE' => $arParams['CATALOG_PARAMS']['SHOW_OLD_PRICE'],
					'SHOW_MAX_QUANTITY' => $arParams['CATALOG_PARAMS']['SHOW_MAX_QUANTITY'],
					'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['CATALOG_PARAMS']['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['CATALOG_PARAMS']['~MESS_SHOW_MAX_QUANTITY'] : ''),
					'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['CATALOG_PARAMS']['RELATIVE_QUANTITY_FACTOR']) ? $arParams['CATALOG_PARAMS']['RELATIVE_QUANTITY_FACTOR'] : ''),
					'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['CATALOG_PARAMS']['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['CATALOG_PARAMS']['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
					'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['CATALOG_PARAMS']['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['CATALOG_PARAMS']['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
					'MESS_BTN_BUY' => (isset($arParams['CATALOG_PARAMS']['~MESS_BTN_BUY']) ? $arParams['CATALOG_PARAMS']['~MESS_BTN_BUY'] : ''),
					'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['CATALOG_PARAMS']['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['CATALOG_PARAMS']['~MESS_BTN_ADD_TO_BASKET'] : ''),
					'MESS_BTN_SUBSCRIBE' => (isset($arParams['CATALOG_PARAMS']['~MESS_BTN_SUBSCRIBE']) ? $arParams['CATALOG_PARAMS']['~MESS_BTN_SUBSCRIBE'] : ''),
					'MESS_BTN_DETAIL' => (isset($arParams['CATALOG_PARAMS']['~MESS_BTN_DETAIL']) ? $arParams['CATALOG_PARAMS']['~MESS_BTN_DETAIL'] : ''),
					'MESS_NOT_AVAILABLE' => (isset($arParams['CATALOG_PARAMS']['~MESS_NOT_AVAILABLE']) ? $arParams['CATALOG_PARAMS']['~MESS_NOT_AVAILABLE'] : ''),
					'MESS_BTN_COMPARE' => (isset($arParams['CATALOG_PARAMS']['~MESS_BTN_COMPARE']) ? $arParams['CATALOG_PARAMS']['~MESS_BTN_COMPARE'] : ''),

					'USE_ENHANCED_ECOMMERCE' => (isset($arParams['CATALOG_PARAMS']['USE_ENHANCED_ECOMMERCE']) ? $arParams['CATALOG_PARAMS']['USE_ENHANCED_ECOMMERCE'] : ''),
					'DATA_LAYER_NAME' => (isset($arParams['CATALOG_PARAMS']['DATA_LAYER_NAME']) ? $arParams['CATALOG_PARAMS']['DATA_LAYER_NAME'] : ''),
					'BRAND_PROPERTY' => (isset($arParams['CATALOG_PARAMS']['BRAND_PROPERTY']) ? $arParams['CATALOG_PARAMS']['BRAND_PROPERTY'] : ''),

					'TEMPLATE_THEME' => (isset($arParams['CATALOG_PARAMS']['TEMPLATE_THEME']) ? $arParams['CATALOG_PARAMS']['TEMPLATE_THEME'] : ''),
					"ADD_SECTIONS_CHAIN" => "N",
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['CATALOG_PARAMS']['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['CATALOG_PARAMS']['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arParams['FOLDER'].$arParams['SEF_URL_TEMPLATES']['compare'],
					'COMPARE_NAME' => $arParams['CATALOG_PARAMS']['COMPARE_NAME'],
					'USE_COMPARE_LIST' => 'Y',
					'BACKGROUND_IMAGE' => (isset($arParams['CATALOG_PARAMS']['SECTION_BACKGROUND_IMAGE']) ? $arParams['CATALOG_PARAMS']['SECTION_BACKGROUND_IMAGE'] : ''),
					'COMPATIBLE_MODE' => (isset($arParams['CATALOG_PARAMS']['COMPATIBLE_MODE']) ? $arParams['CATALOG_PARAMS']['COMPATIBLE_MODE'] : ''),
					'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['CATALOG_PARAMS']['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['CATALOG_PARAMS']['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
					'SHOW_ALL_WO_SECTION' => 'Y',
				)
);
			?>
		</div>
	</section>
