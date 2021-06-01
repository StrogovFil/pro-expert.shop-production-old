<?
CModule::IncludeModule("sale");

AddEventHandler("sale", "onSaleDeliveryHandlersBuildList", array('CFTeaGain', 'Init'));

class CFTeaGain
{
	function Init()
	{
		return array(
			"SID" => "gain",
			"NAME" => "Доставка по коэффициенту",
			"DESCRIPTION" => "Расчёт стоимости доставки в зависимости от стоимости заказа и коэффициента",
			"DESCRIPTION_INNER" => "Расчёт стоимости доставки в зависимости от стоимости заказа и коэффициента",
			"BASE_CURRENCY" => COption::GetOptionString("sale", "default_currency", "RUB"),
			"HANDLER" => __FILE__,

			"DBGETSETTINGS" => array("CFTeaGain", "GetSettings"),
			"DBSETSETTINGS" => array("CFTeaGain", "SetSettings"),
			"GETCONFIG" => array("CFTeaGain", "GetConfig"),
			"COMPABILITY" => array("CFTeaGain", "Compability"),
			"CALCULATOR" => array("CFTeaGain", "Calculate"),

			"PROFILES" => array(
				"gain" => array(
					"TITLE" => "По городу",
					"DESCRIPTION" => "Доставка в течении дня",
					"RESTRICTIONS_WEIGHT" => array(0),
					"RESTRICTIONS_SUM" => array(0),
				),
			)
		);
	}
	
	function GetConfig()
	{
		$arConfig = array(
			"CONFIG_GROUPS" => array(
				"all" => 'Настройки стоимости',
			),
			"CONFIG" => array(
				'GAIN' => array(
					"TYPE" => "STRING",
					"DEFAULT" => "",
					"TITLE" => 'Коэффициент',
					"GROUP" => "all",
				)
			),
		);

		return $arConfig;
	}

	function SetSettings($arSettings)
	{
		foreach ($arSettings as $key => $value) {
			if (strlen($value) > 0) {
				$arSettings[$key] = doubleval($value);
			} else {
				unset($arSettings[$key]);
			}
		}

		return serialize($arSettings);
	}

	function GetSettings($strSettings)
	{
		return unserialize($strSettings);
	}

	function Compability($arOrder, $arConfig)
	{
		return array('gain');
	}
	
	function Calculate($profile, $arConfig, $arOrder, $STEP, $TEMP = false)
	{
		if (!$arConfig["GAIN"]["VALUE"])
			$fGain = 0;
		else
			$fGain = floatval($arConfig["GAIN"]["VALUE"]);
		
		$fSumOrder = floatval($arOrder['PRICE']);
		$fDeliveryPrice = $fGain * $fSumOrder;
		
		return array(
			"RESULT" => "OK",
			"VALUE" => $fDeliveryPrice
		);
	}
}