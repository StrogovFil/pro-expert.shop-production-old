<?
namespace WD\Antirutin\Plugins\Element;

use
	\WD\Antirutin\Helper,
	\WD\Antirutin\IBlock,
	\WD\Antirutin\ValueItem,
	\WD\Antirutin\PluginElement;

class FunctionExec extends PluginElement {
	
	protected $arFieldsFilter = [
		'FIELDS' => ['TYPE_FULL' => ['S', 'S:HTML', 'N'], 'IS_WRITEABLE' => 'Y'],
		'PROPERTIES' => ['TYPE_FULL' => ['S', 'S:HTML', 'N'], 'IS_WRITEABLE' => 'Y'],
		'SEO' => ['IS_WRITEABLE' => 'Y'],
	];
	
	// *******************************************************************************************************************
	// Main methods
	// *******************************************************************************************************************
	
	/**
	 *	Execute!
	 */
	public function processElement($intElementId){
		if($this->isEmpty('field')){
			$this->setError(static::getMessage('ERROR_NO_FIELD'));
			return false;
		}
		if($this->isEmpty('function_name')){
			$this->setError(static::getMessage('ERROR_NO_FUNCTION'));
			return false;
		}
		return $this->processElementByFunction($intElementId);
	}
	
	/**
	 *	Process one element with selected function
	 */
	protected function processElementByFunction($intElementId){
		$bDebug = $this->get('php_debug_mode') == 'Y';
		$arValues = $this->getValues($intElementId);
		$arFunc = $this->getFunctionArray($this->get('function_name'));
		if($bDebug){
			$this->debug('Function: '.var_export($arFunc['FUNC'], true));
		}
		foreach($arValues as $key => $obValue){
			$mValue = $obValue->getValue();
			$bHtmlValue = is_array($mValue) && count($mValue) == 2 && isset($mValue['TEXT']) && isset($mValue['TYPE']);
			$mValueLink = &$mValue;
			if($bHtmlValue) {
				$mValueLink = &$mValue['TEXT'];
			}
			$arArguments = [];
			foreach($arFunc['ARGS'] as $strArg => $arArg){
				if($strArg == 'VALUE'){
					$arArguments[] = $mValueLink;
				}
				else{
					$strArgumentValue = $this->getFuncArgument($strArg);
					if(is_string($strArgumentValue) && !strlen($strArgumentValue) || is_null($strArgumentValue)){
						$strArgumentValue = null;
						/*
						if(!$arArg['REQUIRED']){
							break;
						}
						else{
							$strArgumentValue = null;
						}
						*/
					}
					$arArguments[] = $strArgumentValue;
				}
			}
			$this->prepareArguments($arFunc, $arArguments);
			$mValueLink = call_user_func_array($arFunc['NAMESPACE'].$arFunc['FUNC'], $arArguments);
			$obValue->setValue($mValue);
			if($bDebug){
				$this->debug('Arguments: '.var_export($arArguments, true));
				$this->debug('Result: '.htmlspecialcharsbx(print_r($mValue, true)));
			}
		}
		if(!$bDebug){
			$this->saveValues($intElementId, $arValues);
		}
		else{
			$this->setBreaked(true);
		}
		return true;
	}
	
	/**
	 *	Prepare arguments
	 */
	protected function prepareArguments(&$arFunc, &$arArguments){
		foreach($arArguments as $key => &$value){
			switch($value){
				case '#TRUE#':
					$value = true;
					break;
				case '#FALSE#':
					$value = false;
					break;
				case '#NULL#':
					$value = null;
					break;
			}
		}
		if(isset($arFunc['CALLBACK'])){
			call_user_func_array($arFunc['CALLBACK'], [&$arFunc, &$arArguments]);
		}
	}
	
	/**
	 *	Get list (tree) of function
	 */
	protected function getFunctionList($bNoGroups=false){
		return require __DIR__.'/../../../include/shared/'.pathinfo(__DIR__, PATHINFO_BASENAME).'/include.php';
	}
	
	/**
	 *	Get array of selected function
	 */
	protected function getFunctionArray($strFuncName){
		$arFunctions = $this->getFunctionList(true);
		return $arFunctions[$strFuncName];
	}
	
	/**
	 *	Get saved function argument
	 */
	protected function getFuncArgument($strArgument){
		return $this->get('arg_'.$strArgument);
	}
	
	/**
	 *	Get field/property values
	 */
	protected function getValues($intElementId){
		$arResult = [];
		$strField = $this->get('field');
		if($this->isField($strField)){
			$arFeatures = ['FIELDS' => [$strField]];
			$arElement = IBlock::getElementArray($intElementId, $this->intIBlockId, $arFeatures, true);
			$arResult[] = [
				'FIELD' => $strField,
				'VALUE' => $arElement[$strField],
			];
		}
		elseif($intPropertyId = $this->isProperty($strField)){
			$arFeatures = ['PROPERTY_ID' => [$intPropertyId], 'EMPTY_PROPERTIES' => true];
			$arElement = IBlock::getElementArray($intElementId, $this->intIBlockId, $arFeatures, true);
			$arProperty = $arElement['PROPERTIES'][$intPropertyId];
			if($arProperty['MULTIPLE'] == 'Y' && is_array($arProperty['~VALUE'])){
				foreach($arProperty['~VALUE'] as $key => $value){
					$arResult[] = [
						'FIELD' => $strField,
						'FIELD_ARRAY' => $arProperty,
						'VALUE' => $value,
						'DESCRIPTION' => $arProperty['DESCRIPTION'][$key],
					];
				}
			}
			else{
				$arResult[] = [
					'FIELD' => $strField,
					'FIELD_ARRAY' => $arProperty,
					'VALUE' => $arProperty['~VALUE'],
					'DESCRIPTION' => $arProperty['DESCRIPTION'],
				];
			}
		}
		elseif($strSeoField = $this->isSeoField($strField)){
			$arFeatures = ['SEO' => true];
			$arElement = IBlock::getElementArray($intElementId, $this->intIBlockId, $arFeatures, true);
			$arResult[] = [
				'FIELD' => $strField,
				'VALUE' => $arElement['SEO'][$strSeoField],
			];
		}
		foreach($arResult as $key => $arValue){
			$arResult[$key] = new ValueItem($arValue);
		}
		return $arResult;
	}
	
	/**
	 *	Save values for element
	 */
	protected function saveValues($intElementId, $arValues){
		$bResult = false;
		$strField = $this->get('field');
		if(!empty($arValues)){
			if($this->isField($strField)){
				$obFirst = $this->cutMultipleValue($arValues, static::MULTIPLE_MODE_FIRST);
				if(is_object($obFirst)){
					$bResult = $this->update($intElementId, [$strField => $obFirst->getValue()]);
				}
			}
			elseif($intPropertyId = $this->isProperty($strField)){
				$obFirst = $this->cutMultipleValue($arValues, static::MULTIPLE_MODE_FIRST);
				if(is_object($obFirst)){
					$arProperty = $obFirst->getFieldArray();
					$arValues = $this->transformObjectToValue($arValues, $arProperty['MULTIPLE'] == 'Y', false,
						$arProperty['WITH_DESCRIPTION'] == 'Y');
					$this->setPropertyValue($intElementId, $intPropertyId, $arValues);
					$bResult = true;
				}
			}
			elseif($strSeoField = $this->isSeoField($strField)){
				$obFirst = $this->cutMultipleValue($arValues, static::MULTIPLE_MODE_FIRST);
				if(is_object($obFirst)){
					$strSeoFieldFull = IBlock::$arSeoMapElement[$strSeoField];
					$this->setSeoField($intElementId, $strSeoFieldFull, $obFirst->getValue());
				}
			}
		}
		return $bResult;
	}
	
}

?>