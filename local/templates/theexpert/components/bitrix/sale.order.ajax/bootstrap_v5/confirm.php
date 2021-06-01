<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y")
{
	$APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>
<h1>Ваш заказ передан в обработку</h1><br/><br/>
<? if (!empty($arResult["ORDER"])): ?>

	<div class="row mb-5">
		<div class="col">
			<?=Loc::getMessage("SOA_ORDER_SUC", array(
				"#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
				"#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
			))?>
			<? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
				<?=Loc::getMessage("SOA_PAYMENT_SUC", array(
					"#PAYMENT_ID#" => $arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']
				))?>
			<? endif ?>
		</div>
	</div>
	<!-- <div class="row mb-5">
		<div class="col">
			<?=Loc::getMessage("SOA_ORDER_SUC1", array("#LINK#" => $arParams["PATH_TO_PERSONAL"]))?>
		</div>
	</div> -->
	<br/>
	<div class="social_sites">
		<h2>Мы в социальных сетях</h2>
		<div class="footer-base-card-social">
            <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW"   => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/footer_social.php",
                    )
                );
            ?>
        </div>
	</div>
	<br/><br/>
	<div class="interesovat">

		<div class="" data-entity="parent-container">
        <div class="h2 product-promo-title" data-entity="header" data-showed="false" style="display: none; opacity: 0;">Вас могут заинтересовать</div>
        <?
              $APPLICATION->IncludeComponent(
                'bitrix:catalog.section',
                'viewed',
                array(
                  'IBLOCK_TYPE' => catalog,
                  'IBLOCK_ID' => 1,
                  //'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
                  //'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
                  'ELEMENT_SORT_FIELD' => 'shows',
                  'ELEMENT_SORT_ORDER' => 'desc',
                  'ELEMENT_SORT_FIELD2' => 'sort',
                  'ELEMENT_SORT_ORDER2' => 'asc',
                  'PROPERTY_CODE' => $arParams['LIST_PROPERTY_CODE'],
                  'PROPERTY_CODE_MOBILE' => $arParams['LIST_PROPERTY_CODE_MOBILE'],
                  'INCLUDE_SUBSECTIONS' => $arParams['INCLUDE_SUBSECTIONS'],
                  'BASKET_URL' => $arParams['BASKET_URL'],
                  'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                  'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                  'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
                  'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                  'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                  'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                  'CACHE_TIME' => $arParams['CACHE_TIME'],
                  'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                  'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                  'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
                  'PRICE_CODE' => $arParams['~PRICE_CODE'],
                  'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                  'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
                  'PAGE_ELEMENT_COUNT' => 3,
                  'FILTER_IDS' => array($elementId),

                  "SET_TITLE" => "N",
                  "SET_BROWSER_TITLE" => "N",
                  "SET_META_KEYWORDS" => "N",
                  "SET_META_DESCRIPTION" => "N",
                  "SET_LAST_MODIFIED" => "N",
                  "ADD_SECTIONS_CHAIN" => "N",

                  'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                  'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                  'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
                  'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
                  'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],

                  'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                  'OFFERS_FIELD_CODE' => $arParams['LIST_OFFERS_FIELD_CODE'],
                  'OFFERS_PROPERTY_CODE' => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                  'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
                  'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
                  'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
                  'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
                  'OFFERS_LIMIT' => $arParams['LIST_OFFERS_LIMIT'],

                  'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
                  'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
                  'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
                  'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                  'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                  'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
                  'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
'LABEL_PROP' => $arParams['LABEL_PROP'],
                  'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                  'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                  'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                  'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                  'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                  'PRODUCT_ROW_VARIANTS' => "[{'VARIANT':'3','BIG_DATA':false}]",
                  'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                  'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                  'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                  'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                  'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                  'DISPLAY_TOP_PAGER' => 'N',
                  'DISPLAY_BOTTOM_PAGER' => 'N',
                  'HIDE_SECTION_DESCRIPTION' => 'Y',

                  'RCM_TYPE' => isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
                  'RCM_PROD_ID' => $elementId,
                  'SHOW_FROM_SECTION' => 'Y',

                  'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                  'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                  'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                  'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                  'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                  'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                  'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                  'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                  'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                  'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                  'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                  'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                  'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                  'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                  'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                  'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                  'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                  'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                  'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                  'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),
'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                  'ADD_TO_BASKET_ACTION' => $basketAction,
                  'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                  'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                  'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                  'BACKGROUND_IMAGE' => '',
                  'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                ),
                $component
              );
              ?>
      </div>
	</div>
		<div class="comfirm_akcii">
		<h2>Акции</h2>
            <br>
            <br>
		<?$APPLICATION->IncludeComponent(
  "bitrix:news.list",
  "news_bottom_slider",
  Array(
    "IBLOCK_TYPE" => content,
    "IBLOCK_ID" => 5,
    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
    "SORT_BY1" => $arParams["SORT_BY1"],
    "SORT_ORDER1" => $arParams["SORT_ORDER1"],
    "SORT_BY2" => $arParams["SORT_BY2"],
    "SORT_ORDER2" => $arParams["SORT_ORDER2"],
    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => "Y",
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "FILTER_NAME" => '',
    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
  ),
  $component
);?>
	</div>
	<br/>
	<br/>
	<div class="comfirm_stati">
		<h2>Статьи</h2>
        <br>
        <br>
		<?if ($iRequestDesigner)
  $arrArticlesFilter = array("ACTIVE" => "Y", 'PROPERTY_DESIGNERS' => $iRequestDesigner);
?>
		<?$APPLICATION->IncludeComponent(
  "bitrix:news.list",
  "news_bottom_slider",
  Array(
    "IBLOCK_TYPE" => content,
    "IBLOCK_ID" => 10,
    "NEWS_COUNT" => $arParams["NEWS_COUNT"],
    "SORT_BY1" => $arParams["SORT_BY1"],
    "SORT_ORDER1" => $arParams["SORT_ORDER1"],
    "SORT_BY2" => $arParams["SORT_BY2"],
    "SORT_ORDER2" => $arParams["SORT_ORDER2"],
    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => "Y",
    "PARENT_SECTION" => 663,
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "FILTER_NAME" => 'arrArticlesFilter',
    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
  ),
  $component
);?>
	</div>
	<br/>
	<br/>
	<?
	if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y')
	{
		if (!empty($arResult["PAYMENT"]))
		{
			foreach ($arResult["PAYMENT"] as $payment)
			{
				if ($payment["PAID"] != 'Y')
				{
					if (!empty($arResult['PAY_SYSTEM_LIST'])
						&& array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
					)
					{
						$arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

						if (empty($arPaySystem["ERROR"]))
						{
							?>

							<div class="row mb-2">
								<div class="col">
									<h3 class="pay_name"><?=Loc::getMessage("SOA_PAY") ?></h3>
								</div>
							</div>
							<div class="row mb-2 align-items-center">
								<div class="col-auto"><strong><?=$arPaySystem["NAME"] ?></strong></div>
								<div class="col"><?=CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?></div>
							</div>
							<div class="row mb-2">
								<div class="col">
									<? if (strlen($arPaySystem["ACTION_FILE"]) > 0 && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
									<?
										$orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
										$paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
									?>
									<script>
										window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
									</script>
									<?=Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&PAYMENT_ID=".$paymentAccountNumber))?>
									<? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
									<br/>
										<?=Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$orderAccountNumber."&pdf=1&DOWNLOAD=Y"))?>
									<? endif ?>
									<? else: ?>
										<?=$arPaySystem["BUFFERED_OUTPUT"]?>
									<? endif ?>
								</div>
							</div>



							<?
						}
						else
						{
							?>
							<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
							<?
						}
					}
					else
					{
						?>
						<div class="alert alert-danger" role="alert"><?=Loc::getMessage("SOA_ORDER_PS_ERROR")?></div>
						<?
					}
				}
			}
		}
	}
	else
	{
		?>
		<div class="alert alert-danger" role="alert"><?=$arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR']?></div>
		<?
	}
	?>

<? else: ?>


	<div class="row mb-2">
		<div class="col">
			<div class="alert alert-danger" role="alert"><strong><?=Loc::getMessage("SOA_ERROR_ORDER")?></strong><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])])?><br />
				<?=Loc::getMessage("SOA_ERROR_ORDER_LOST1")?></div>
		</div>
	</div>

<? endif ?>