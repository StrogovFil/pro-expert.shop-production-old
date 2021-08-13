<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
//$res = CIBlockElement::GetList(array(), array('ID'=>$item['ID']), false, false, array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL'));
//$arElement = $res->GetNext();
?>
	<div class="catalog-item-link" data-entity="image-wrapper">
		<div class="catalog-item-bg"></div>
		<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>" class="catalog-item-pic">
		<span class="product-item-image-slider-slide-container slide" id="<?=$itemIds['PICT_SLIDER']?>"
			<?=($showSlider ? '' : 'style="display: none;"')?>
			data-slider-interval="<?=$arParams['SLIDER_INTERVAL']?>" data-slider-wrap="true">
			<?
			if ($showSlider)
			{
				foreach ($morePhoto as $key => $photo)
				{
					?>
					<span class="product-item-image-slide item <?=($key == 0 ? 'active' : '')?>"
						style="background-image: url('<?=$photo['SRC']?>');">
					</span>
					<?
				}
			}
			?>
		</span>
		<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="" style="<?=($showSlider ? 'display: none;' : '')?>" />
		<?
		if ($item['SECOND_PICT'])
		{
			$bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
			?>
			<span class="product-item-image-alternative" id="<?=$itemIds['SECOND_PICT']?>"
				style="background-image: url('<?=$bgImage?>'); <?=($showSlider ? 'display: none;' : '')?>">
			</span>
			<?
		}

		if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
		{
			?>
			<div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>"
				<?=($price['PERCENT'] > 0 ? '' : 'style="display: none;"')?>>
				<span><?=-$price['PERCENT']?>%</span>
			</div>
			<?
		}

		if ($item['LABEL'])
		{
			?>
			<div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>">
				<?
				if (!empty($item['LABEL_ARRAY_VALUE']))
				{
					foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value)
					{
						?>
						<div<?=(!isset($item['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
							<span title="<?=$value?>"><?=$value?></span>
						</div>
						<?
					}
				}
				?>
			</div>
			<?
		}
		?>
		<div class="product-item-image-slider-control-container" id="<?=$itemIds['PICT_SLIDER']?>_indicator"
			<?=($showSlider ? '' : 'style="display: none;"')?>>
			<?
			if ($showSlider)
			{
				foreach ($morePhoto as $key => $photo)
				{
					?>
					<div class="product-item-image-slider-control<?=($key == 0 ? ' active' : '')?>" data-go-to="<?=$key?>"></div>
					<?
				}
			}
			?>
		</div>
		<?
		if ($arParams['SLIDER_PROGRESS'] === 'Y')
		{
			?>
			<div class="product-item-image-slider-progress-bar-container">
				<div class="product-item-image-slider-progress-bar" id="<?=$itemIds['PICT_SLIDER']?>_progress_bar" style="width: 0;"></div>
			</div>
			<?
		}
		?>
	</a>
	<div class="catalog-item-content">
		<a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>" class="catalog-item-title"><span><?=$productTitle?></span></a>
<!--		 <div class="catalog-item-description"><span>--><?//=$item['PREVIEW_TEXT']?><!--</span></div>-->
		<div class="catalog-item-description">
			<div><?=$item['DISPLAY_PROPERTIES']['BRAND']['DISPLAY_VALUE']?></div>
			<div><?=$item['DISPLAY_PROPERTIES']['COUNTRIES']['DISPLAY_VALUE']?></div>
		</div>
		<div class="catalog-item-price" data-entity="price-block">
						<?
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
							<span class="product-item-price-old" id="<?=$itemIds['PRICE_OLD']?>"
								<?=($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '')?>>
								<?=$price['PRINT_RATIO_BASE_PRICE']?>
							</span>
							<?
						}
						?>
						<span class="product-item-price-current" id="<?=$itemIds['PRICE']?>">
							<?if($item['PROPERTIES']['NO_PRICE']['VALUE'] == 'Y'){?>
								Цена по запросу
							<?}else{?>
								<?
								if (!empty($price))
								{
									if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
									{
										echo Loc::getMessage(
											'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
											array(
												'#PRICE#' => $price['PRINT_RATIO_PRICE'],
												'#VALUE#' => $measureRatio,
												'#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
											)
										);
									}
									else
									{
										echo $price['PRINT_RATIO_PRICE'];
									}
								}
								?>
							<?}?>
						</span>
					</div>
					<?if (!$haveOffers)
					{
						if ($actualItem['CAN_BUY'] && $arParams['USE_PRODUCT_QUANTITY'])
						{
							?>
		<div class="product-item-info-container product-item-hidden" data-entity="quantity-block" style="display: none">
								<div class="product-item-amount">
									<div class="product-item-amount-field-container">
										<span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
										<input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number"
											name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
											value="<?=$measureRatio?>">
										<span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
										<span class="product-item-amount-description-container">
											<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
												<?=$actualItem['ITEM_MEASURE']['TITLE']?>
											</span>
											<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
										</span>
									</div>
								</div>
							</div>
							<?
						}
					}
					elseif ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
					{
						if ($arParams['USE_PRODUCT_QUANTITY'])
						{
							?>
							<div class="product-item-info-container product-item-hidden" data-entity="quantity-block" style="display: none">
								<div class="product-item-amount">
									<div class="product-item-amount-field-container">
										<span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
										<input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number"
											name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
											value="<?=$measureRatio?>">
										<span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
										<span class="product-item-amount-description-container">
											<span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
											<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
										</span>
									</div>
								</div>
							</div>
							<?
						}
					}?>
		<div class="product-item-info-container product-item-hidden" data-entity="buttons-block">
			<?
			if (!$haveOffers)
			{
				if ($actualItem['CAN_BUY'])
				{
					?>
                    <?/*
					<div class="product-item-button-container" id="<?=$itemIds['BASKET_ACTIONS']?>">
						<button class="btn catalog-item-buy <?=$buttonSizeClass?> <?if($item['PROPERTIES']['NO_PRICE']['VALUE'] == 'Y'){?>hbtn<?}?>" id="<?=$itemIds['BUY_LINK']?>">
                            Заказать
							<?//$arParams['MESS_BTN_ADD_TO_BASKET'] = "Заказать";?>
							<?//=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
						</button>
					</div>
                    */?>
					<?
				}
				else
				{
					?>
					<div class="product-item-button-container">
						<?
						if ($showSubscribe)
						{
							$APPLICATION->IncludeComponent(
								'bitrix:catalog.product.subscribe',
								'',
								array(
									'PRODUCT_ID' => $actualItem['ID'],
									'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
									'BUTTON_CLASS' => 'btn btn-default '.$buttonSizeClass,
									'DEFAULT_DISPLAY' => true,
									'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
								),
								$component,
								array('HIDE_ICONS' => 'Y')
							);
						}
						?>
						<button class="btn catalog-item-buy <?=$buttonSizeClass?>"
							id="<?=$itemIds['NOT_AVAILABLE_MESS']?>">
							<?=$arParams['MESS_NOT_AVAILABLE']?>
						</button>
					</div>
					<?
				}
			}
			else
			{
				if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
				{
					?>
					<div class="product-item-button-container">
						<?
						if ($showSubscribe)
						{
							$APPLICATION->IncludeComponent(
								'bitrix:catalog.product.subscribe',
								'',
								array(
									'PRODUCT_ID' => $item['ID'],
									'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
									'BUTTON_CLASS' => 'btn btn-default '.$buttonSizeClass,
									'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
									'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
								),
								$component,
								array('HIDE_ICONS' => 'Y')
							);
						}
						?>
						<button class="btn catalog-item-buy <?=$buttonSizeClass?>"
							id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
							<?=($actualItem['CAN_BUY'] ? 'style="display: none;"' : '')?>>
							<?=$arParams['MESS_NOT_AVAILABLE']?>
						</button>
						<div id="<?=$itemIds['BASKET_ACTIONS']?>" <?=($actualItem['CAN_BUY'] ? '' : 'style="display: none;"')?>>
							<button class="btn catalog-item-buy <?=$buttonSizeClass?>" id="<?=$itemIds['BUY_LINK']?>">
								<?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
							</button>
						</div>
					</div>
					<?
				}
				else
				{
					?>
					<div class="product-item-button-container">
						<button class="btn catalog-item-buy <?=$buttonSizeClass?>">
							<?=$arParams['MESS_BTN_DETAIL']?>
						</button>
					</div>
					<?
				}
			}
			?>
		</div>
	<?
	if (
		$arParams['DISPLAY_COMPARE']
		&& (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
	)
	{
		?>
		<div class="product-item-compare-container">
			<div class="product-item-compare">
				<div class="checkbox">
					<label id="<?=$itemIds['COMPARE_LINK']?>">
						<input type="checkbox" data-entity="compare-checkbox">
						<span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
					</label>
				</div>
			</div>
		</div>
		<?
	}
	?>
	</div>
</div>