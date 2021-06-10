<?
namespace WD\Antirutin;

use
	\WD\Antirutin\Helper,
	\WD\Antirutin\Options;

# Include module
$strModuleId = pathinfo(__DIR__, PATHINFO_BASENAME);
\Bitrix\Main\Loader::includeModule($strModuleId);
Helper::loadMessages(__FILE__);
$strLang = 'WDA_OPTIONS_';

# Check rights
$strRight = $APPLICATION->getGroupRight($strModuleId);
if($strRight < 'R'){
	return;
}

# AJAX
$strAjaxAction = \Bitrix\Main\Context::getCurrent()->getRequest()->getQueryList()->get('ajax_action');
if(strlen($strAjaxAction)){
	$arJsonResult = Json::prepare();
	#
	switch($strAjaxAction){
		case 'check_php_path':
			$strPhpPathBase64 = \Bitrix\Main\Context::getCurrent()->getRequest()->getQueryList()->get('php_path');
			$strPhpPath = base64_decode($strPhpPathBase64);
			$arCheckResult = Cli::checkPhpVersion($strPhpPath);
			$arJsonResult['Message'] = $arCheckResult['MESSAGE'];
			$arJsonResult['Success'] = $arCheckResult['SUCCESS'];
			$arJsonResult['PhpVersionTest'] = $arCheckResult['VERSION'];
			$arJsonResult['PhpVersionSite'] = Cli::getSitePhpVersion();
			break;
	}
	#
	Json::output($arJsonResult);
	die();
}

# Tabs
$arTabs = [
	[
		'DIV' => 'general',
		'TAB' => Helper::getMessage($strLang.'TAB_GENERAL_NAME'),
		'TITLE' => Helper::getMessage($strLang.'TAB_GENERAL_DESC'),
		'OPTIONS' => [
			'manual.php',
			'server.php',
			'misc.php',
		],
	], [
		'DIV' => 'rights',
		'TAB' => Helper::getMessage('MAIN_TAB_RIGHTS'),
		'TITLE' => Helper::getMessage('MAIN_TAB_TITLE_RIGHTS'),
		'RIGHTS' => true,
	],
];

# Display all
$obOptions = new Options($arTabs, [
	'DISABLED' => $strRight <= 'R',
]);

?>