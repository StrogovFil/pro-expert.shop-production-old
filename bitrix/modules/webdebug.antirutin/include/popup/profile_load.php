<?
namespace WD\Antirutin;

use
	\WD\Antirutin\Helper;

if(!isset($arParams)){
	#// If in demo-mode, 2nd argument is not '$arParams' :( - this looks like $_1565435424
	# So, we make hack in Helper::includeFile(): $GLOBALS['arParams'] = $arParams;
	global $arParams;
}

if(\Bitrix\Main\Loader::includeSharewareModule('webdebug.antirutin') === MODULE_DEMO){
	print Helper::showNote(Helper::getMessage('WDA_NOTICE_DEMO_PROFILE_SAVE'), true);
	?><style>[data-role="wda-popup-profile-load-notice"]{display:none;}</style><?
	return;
}

print Helper::includeFile('profile_list', $arParams);

?>