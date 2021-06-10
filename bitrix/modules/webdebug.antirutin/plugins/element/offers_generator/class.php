<?
namespace WD\Antirutin\Plugins\Element;

use
	\WD\Antirutin\Helper,
	\WD\Antirutin\IBlock,
	\WD\Antirutin\PluginElement;

class OfferGenerator extends PluginElement {
	
	const GROUP = 'CUSTOM';
	
	protected $arFieldsFilter = [
		'PROPERTIES' => true,
	];
	
	// *******************************************************************************************************************
	// Main methods
	// *******************************************************************************************************************
	
	/**
	 *	Execute!
	 */
	public function processElement($intElementId){
		$intCount = $this->get('count');
		$strActive = $this->get('active') == 'Y' ? 'Y' : 'N';
		$bCopyPrices = $this->get('copy_prices') == 'Y';
		
		# Check input values
		if(!is_numeric($intCount) || $intCount <= 0){
			$this->setError(static::getMessage('ERROR_NO_COUNT'));
			return false;
		}
		if(!($arCatalog = Helper::getCatalogArray($this->intIBlockId))){
			$this->setError(static::getMessage('ERROR_IBLOCK_HAS_NO_OFFERS'));
			return false;
		}
		
		# Set features for get element
		$arFeatues = ['FIELDS' => ['NAME', 'CODE']];
		if($bCopyPrices){
			$arFeatues['PRICES'] = true;
		}
		
		# Get current element
		$arElement = IBlock::getElementArray($intElementId, $this->intIBlockId, $arFeatues);
		if(!strlen($arElement['CODE'])){
			$arElement['CODE'] = \CUtil::translit($arElement['~NAME'], LANGUAGE_ID, [
				'max_len' => 255,
				'change_case' => 'L',
				'replace_space' => '_',
				'replace_other' => '_',
				'delete_repeat_replace' => true,
			]);
		}
		
		# Create offers
		$obElement = new \CIBlockElement;
		for($i = 1; $i <= $intCount; $i++){
			$strRand = randString(8);
			$arOfferFields = [
				'IBLOCK_ID' => $arCatalog['OFFERS_IBLOCK_ID'],
				'ACTIVE' => 'N',
				'NAME' => sprintf('%s %s', $arElement['~NAME'], $strRand),
				'CODE' => sprintf('%s_%s', $arElement['CODE'], toLower($strRand)),
				'PROPERTY_VALUES' => [
					$arCatalog['OFFERS_PROPERTY_ID'] => $intElementId,
				],
			];
			if($intOfferId = $obElement->add($arOfferFields, false, false, false)){
				$obElement->update($intOfferId, [
					'ACTIVE' => $strActive,
					'NAME' => sprintf('%s %s', $arElement['~NAME'], $intOfferId),
					'CODE' => sprintf('%s_%s', $arElement['CODE'], $intOfferId),
				]);
				if($bCopyPrices && $arElement['PRICES']){
					foreach($arElement['PRICES'] as $intPriceId => $arPrice){
						Helper::setProductPrice($intOfferId, $intPriceId, $arPrice['PRICE'], $arPrice['CURRENCY']);
						if($arPrice['EXTRA_ID']){
							Helper::setProductPriceExtra($intOfferId, $intPriceId, $arPrice['EXTRA_ID']);
						}
					}
				}
			}
		}
		# Change product type
		if($intOfferId){
			\CCatalogProduct::update($intElementId, ['TYPE' => \Bitrix\Catalog\ProductTable::TYPE_SKU]);
		}

		# Return
		return $intOfferId ? true : false;
	}
	
}

?>