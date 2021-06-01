<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @var array $arUrls */
/** @var array $arHeaders */
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;
$bCiBColumn = false;
$bSumColumn = false;

if ($normalCount > 0):
?>
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
		<table id="basket_items">
			<thead>
				<tr>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "SUM")
						{
							$bSumColumn = true;
							$sumId = $id;
							continue;
						}
						elseif ($arHeader["id"] == "PREVIEW_PICTURE")
							continue;

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="cart-header-cell" colspan="2" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="cart-header-cell" id="col_<?=$arHeader["id"];?>">
						<?
						else:
						?>
							<td class="cart-header-cell" id="col_<?=$arHeader["id"];?>">
						<?
						endif;
						?>
							<?=$arHeader["name"]; ?>
							</td>
					<?
					endforeach;
					
					if ($bSumColumn && $sumId):
					?>
						<td class="cart-header-cell"><?=$arResult["GRID"]["HEADERS"][$sumId]["name"]; ?></td>
					<?
					endif;
					
					if ($bDeleteColumn || $bDelayColumn):
					?>
						<td class="cart-header-cell"></td>
					<?
					endif;
					?>
				</tr>
			</thead>

			<tbody>
				<?
				$skipHeaders = array('PROPS', 'DELAY', 'DELETE', 'TYPE', 'WEIGHT', 'PROPERTY_COUNT_IN_BOX_VALUE', 'PREVIEW_PICTURE');

				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
					?>
					<tr class="cart-row" id="<?=$arItem["ID"]?>" data-item-name="<?=$arItem["NAME"]?>" data-item-brand="<?=$arItem[$arParams['BRAND_PROPERTY']."_VALUE"]?>" data-item-price="<?=$arItem["PRICE"]?>" data-item-currency="<?=$arItem["CURRENCY"]?>" >
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["name"] == '')
								$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
							
							
							if ($arHeader["id"] == "SUM")
							{
								$sumId = $arHeader["id"];
								continue;
							}

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="cart-row-cell cart-row-pic-wrap">
									<div class="bx_ordercart_photo_container">
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;

										if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="cart-row-pic" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="cart-row-cell cart-row-title-wrap">
									<div class="cart-row-title">
										<div class="cart-row-title-name">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?></div>
									</div>
									<?
									if ($bCiBColumn)
									{?>
										<div class="bx_ordercart_art">
											<?=GetMessage("SALE_ARTNUMBER")?><span><?=$arItem["PROPERTY_COUNT_IN_BOX_VALUE"]?></span>
										</div>
									<? } ?>
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):
										?>
										<div class="bx_ordercart_itemart">
										<?
												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo htmlspecialcharsbx($val["NAME"]).":&nbsp;<span>".$val["VALUE"]."</span><br/>";
											endforeach;
										?>
										</div>
										<?
										endif;
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										$propsMap = array();
										foreach ($arItem["PROPS"] as $propValue)
										{
											if (empty($propValue) || !is_array($propValue))
												continue;
											$propsMap[$propValue['CODE']] = (isset($propValue['~VALUE']) ? $propValue['~VALUE'] : $propValue['VALUE']);
										}
										unset($propValue);

										foreach ($arItem["SKU_DATA"] as $propId => $arProp):
											$selectedIndex = 0;
											// if property contains images or values
											$isImgProperty = false;
											if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"]))
											{
												$counter = 0;
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													$counter++;
													if (isset($propsMap[$arProp['CODE']]))
													{
														if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['XML_ID'])
															$selectedIndex = $counter;
													}
													if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])
														&& !empty($arVal["PICT"]['SRC']))
													{
														$isImgProperty = true;
													}
												}
												unset($counter);
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											$marginLeft = 0;
											if ($countValues > 5 && $selectedIndex > 5)
												$marginLeft = ((5 - $selectedIndex)*20).'%';

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">
													<span class="bx_item_section_name_gray">
														<?=htmlspecialcharsbx($arProp["NAME"])?>:
													</span>
													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left: <?=$marginLeft; ?>"
																class="sku_prop_list"
																>
																<?
																$counter = 0;
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
																	$counter++;
																	$selected = ($selectedIndex == $counter ? ' bx_active' : '');
																?>
																	<li style="width:10%;"
																		class="sku_prop<?=$selected?>"
																		data-sku-selector="Y"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-sku-name="<?=htmlspecialcharsbx($arSkuValue["NAME"]); ?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																	>
																		<a href="javascript:void(0)" class="cnt"><span class="cnt_item" style="background-image:url(<?=$arSkuValue["PICT"]["SRC"];?>)"></span></a>
																	</li>
																<?
																endforeach;
																unset($counter);
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">
													<span class="bx_item_section_name_gray">
														<?=htmlspecialcharsbx($arProp["NAME"])?>:
													</span>
													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left: <?=$marginLeft; ?>;"
																class="sku_prop_list"
																>
																<?
																if (!empty($arProp["VALUES"]))
																{
																	$counter = 0;
																	foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
																		$counter++;
																		$selected = ($selectedIndex == $counter ? ' bx_active' : '');
																	?>
																		<li style="width:10%;"
																			class="sku_prop<?=$selected?>"
																			data-sku-selector="Y"
																			data-value-id="<?=($arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory' ? $arSkuValue['XML_ID'] : htmlspecialcharsbx($arSkuValue['NAME'])); ?>"
																			data-sku-name="<?=htmlspecialcharsbx($arSkuValue["NAME"]); ?>"
																			data-element="<?=$arItem["ID"]?>"
																			data-property="<?=$arProp["CODE"]?>"
																		>
																			<a href="javascript:void(0)" class="cnt"><?=htmlspecialcharsbx($arSkuValue["NAME"]); ?></a>
																		</li>
																	<?
																	endforeach;
																	unset($counter);
																}
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="cart-row-cell cart-row-count-wrap price">
									<div class="centered">
										<div class="cart-row-count">
										<?
										$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
										$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
										$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
										
										if (!isset($arItem["MEASURE_RATIO"]))
											$arItem["MEASURE_RATIO"] = 1;
											
										if (floatval($arItem["MEASURE_RATIO"]) != 0)
										{?>
											<span href="javascript:void(0);" class="cart-row-count-btn minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"><i class="icon icon-angle-left"></i></span>
										<? } ?>
											<input class="cart-row-count-input" type="text" size="3" id="QUANTITY_INPUT_<?=$arItem["ID"]?>" name="QUANTITY_INPUT_<?=$arItem["ID"]?>" maxlength="18" value="<?=$arItem["QUANTITY"]?>" onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)" />
										<? if (floatval($arItem["MEASURE_RATIO"]) != 0)
										{?>
											<span href="javascript:void(0);" class="cart-row-count-btn plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"><i class="icon icon-angle-right"></i></span>
										<? }
										if (isset($arItem["MEASURE_TEXT"]))
										{?>
											<div class="measure" style="display: none"><?=htmlspecialcharsbx($arItem["MEASURE_TEXT"])?></div>
										<? } ?>
										</div>
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="cart-row-cell cart-row-price-wrap">
										<div class="cart-row-price" id="current_price_<?=$arItem["ID"]?>">
											<?//=$arItem["PRICE_FORMATED"]?>
											<?echo "По запросу";?>
										</div>
										<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<?=$arItem["FULL_PRICE_FORMATED"]?>
											<?endif;?>
										</div>
									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?									
									echo $arItem[$arHeader["id"]];
									?>
								</td>
							<?
							endif;
						endforeach;
						
						if ($bSumColumn && $sumId):
						?>						
						<td class="cart-row-cell cart-row-price-wrap cart-row-price-wrap2">
							<div id="sum_<?=$arItem["ID"]?>" class="cart-row-price">
								<?//echo $arItem[$sumId];?>
								<?echo "По запросу";?>
							</div>
						</td>
						<?endif;
						
						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="cart-row-cell cart-row-remove-wrap">
								<?
								if ($bDelayColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>" title="<?=GetMessage("SALE_DELAY")?>">
										<div class="icon-basket-action icon-basket-action-delay isb"></div>
									</a>
								<?
								endif;
								if ($bDeleteColumn):
									?>
									<a class="cart-row-remove" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>" onclick="return deleteProductRow(this)" title="<?=GetMessage("SALE_DELETE")?>">
										<i class="icon icon-delete"></i>
									</a>
									<?
								endif;
								?>
							</td>
						<?
						endif;
						?>
					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?=htmlspecialcharsbx(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=htmlspecialcharsbx(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=htmlspecialcharsbx($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=($arParams["QUANTITY_FLOAT"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="auto_calculation" value="<?=($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y"?>" />

	<div class="bx_ordercart_order_pay">

		<div class="bx_ordercart_order_pay_left" id="coupons_block">
		<?
		if ($arParams["HIDE_COUPON"] != "Y")
		{
		?>
			<div class="bx_ordercart_coupon">
				<a href="javascript:void(0)" onclick="showCouponBox(this)"><?=GetMessage("STB_COUPON_PROMT")?></a>
				<div id="bx_ordercart_coupon_box" class="bx_ordercart_coupon_box">
					<span><?=GetMessage("STB_COUPON_PROMT_TEXT")?></span>
					<input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();">
					<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?=GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?=GetMessage('SALE_COUPON_APPLY'); ?></a>
				</div>
			</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
						if (isset($oneCoupon['CHECK_CODE_TEXT']))
						{
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?></div></div><?
					}
					unset($couponClass, $oneCoupon);
				}
		}
		else
		{
			?>&nbsp;<?
		}
?>
		</div>
	</div>

	
		<div class="cart-summary">

			<div class="container" style="margin-bottom: 0;">
				<form action="" class="trtr"></form>
				<form class="form-order" id="form-order">
					<div class="form-order-row">
						<label class="form-label form-label-shorttitle">
							<input type="text" class="form-input form-input-name" required>
							<span class="form-label-title">Имя <span class="form-label-note">Введите имя</span></span>
						</label>
					</div>
					<div class="form-order-row">
						<label class="form-label form-label-shorttitle">
							<input type="text" class="form-input js-phone form-input-phone" required>
							<span class="form-label-title">Телефон <span class="form-label-note">Введите телефон</span></span>
						</label>
					</div>
					<div class="form-order-row">
						<label class="form-label form-label-shorttitle">
							<input type="text" class="form-input form-input-mail" required>
							<span class="form-label-title">E-mail <span class="form-label-note">Введите e-mail</span></span>
						</label>
					</div>
					<div class="form-order-row form-order-row-btn" style="text-align: center;">
						<button type="submit" form="form-order" class="btn" id="btn-order">Отправить запрос</button>
					</div>
				</form>
			</div>

			<script>
			$(document).ready(function() {
				$('#form-order').on('submit', function(e) {
					e.preventDefault();
					var name_val = $(this).find(".form-input-name").val();
					var phone_val = $(this).find(".form-input-phone").val();
					var mail_val = $(this).find(".form-input-mail").val();
					$.ajax({
						type: 'POST',
						url: '/personal/basket/ajax.php',
						data: {name : name_val, phone : phone_val, mail : mail_val},
						success: function(res) {
							$('#form-order').html(res);
						}
					});
				});
			});
			</script>

            <!-- <div class="h1 cart-summary-title"><?//=GetMessage("SALE_TOTAL")?> <span id="allSum_FORMATED" class="nobr"> -->
				<?//=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?>
				<?//echo "По запросу";?>
			<!-- </span></div> -->
            <!-- <a href="javascript:void(0)" onclick="checkOut();" class="btn"><?//=GetMessage("SALE_ORDER")?></a> -->
        </div>
        <div class="cart-note">Стоимость дополнительных услуг расчитывается индивидуально. Точную стоимость с вами согласует оператор.</div>

<!--<div class="bx_ordercart_order_pay_right">
			<table class="bx_ordercart_order_sum">
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):/*?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
						<td id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></td>
					</tr>
					<?*/
					$showTotalPrice = (float)$arResult["DISCOUNT_PRICE_ALL"] > 0;
					?>
						<tr style="display: <?=($showTotalPrice ? 'table-row' : 'none'); ?>;">
							<td class="custom_t1"></td>
							<td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
								<?=($showTotalPrice ? $arResult["PRICE_WITHOUT_DISCOUNT"] : ''); ?>
							</td>
						</tr>
					<?
					if (floatval($arResult['allVATSum']) > 0):
						?>
						<tr>
							<td><?echo GetMessage('SALE_VAT')?></td>
							<td id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></td>
						</tr>
						<?
					endif;
					?>
				<?endif;?>
			</table>
		</div>
	</div>
</div>-->
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;