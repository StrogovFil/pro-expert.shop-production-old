<?
namespace WD\Antirutin;

use
	\WD\Antirutin\Helper,
	\WD\Antirutin\IBlock;

$strCurrency = $this->arSavedData['currency'];

$intPrice = IBlock::isPrice($strField);

static $arBasePrice = null;
if(is_null($arBasePrice)){
	$arBasePrice = \CCatalogGroup::getBaseGroup();
	$arBasePrice = is_array($arBasePrice) ? $arBasePrice : [];
}

$bBasePrice = $arBasePrice['ID'] == $intPrice;

$bMarkup = $this->get('price_mode') == 'markup';

$arCatalog = Helper::getCatalogArray($this->intIBlockId);

$strRandId = Helper::randString(true);

?>
<?if($intPrice && !$bBasePrice):?>
	<br/>
	<div id="<?=$strRandId;?>_sel">
		<div class="wda-radio-selector" style="display:inline-block;">
			<label>
				<input type="radio" name="<?=$this->getInputName('price_mode', $bMultiple);?>" value="value"
					<?if(!$bMarkup):?> checked="checked"<?endif?> />
				<span><?=static::getMessage('PRICE_PRICE_MODE_VALUE');?></span>
			</label>
			<label>
				<input type="radio" name="<?=$this->getInputName('price_mode', $bMultiple);?>" value="markup"
					<?if($bMarkup):?> checked="checked"<?endif?> />
				<span><?=static::getMessage('PRICE_PRICE_MODE_MARKUP');?></span>
			</label>
		</div>
	</div>
	<br/>
<?endif?>

<div>
	<div id="<?=$strRandId;?>_price_value">
		<input type="text" name="<?=$this->getInputName('value', $bMultiple);?>" value="<?=$mValue;?>" size="15" />
		<div style="display:inline-block;">
			<?=$this->selectBox($this->getInputName('currency', $bMultiple), Helper::getCurrencyList(true), $strCurrency, null, 
				'class="wda-no-min-width"');?>
		</div>
		<?if($intPrice):?>
			<div style="margin-top:6px;" id="<?=$strRandId;?>_del">
				<?=Helper::showNote(static::getMessage('PRICE_VALUE_DELETE_NOTICE'), true);?>
			</div>
		<?endif?>
	</div>
	<?if($intPrice && !$bBasePrice):?>
		<div id="<?=$strRandId;?>_price_markup" style="display:none;">
			<?=\CExtra::selectBox($this->getInputName('markup', $bMultiple), $this->get('markup'), 
				static::getMessage('PRICE_PRICE_MODE_DELETE'), '', '');?>
		</div>
	<?endif?>
</div>

<?if($intPrice):?>
	<script>
		// Substitute "delete"
		$('a[data-role="wda_set_values_price_value_delete"]', '#<?=$strRandId;?>_del').bind('click', function(e){
			e.preventDefault();
			$(this).closest('[data-role="field_input"]').find('input[type="text"][name^="actions"]').val($(this).text());
		});
		<?if(!$bBasePrice):?>
			// Select price value type
			$('input[type="radio"]', '#<?=$strRandId;?>_sel').bind('change', function(e){
				e.preventDefault();
				let
					current = $('input[type="radio"]:checked', '#<?=$strRandId;?>_sel').val();
					console.log(current);
					console.log($('#<?=$strRandId;?>_price_' + current));
					$('#<?=$strRandId;?>_price_' + current).show().siblings().hide();
			});
			$('input[type="radio"]:checked', '#<?=$strRandId;?>_sel').trigger('change');
		<?endif?>
	</script>
<?endif?>