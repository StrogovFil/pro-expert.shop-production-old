<?
namespace WD\Antirutin;

use
	\WD\Antirutin\Helper;

if(!isset($arParams)){
	# If in demo-mode, 2nd argument is not '$arParams' :( - this looks like $_1565435424
	# So, we make hack in Helper::includeFile(): $GLOBALS['arParams'] = $arParams;
	global $arParams;
}

$arValues = is_array($arParams['SECTIONS_ID_SELECTED']) ? $arParams['SECTIONS_ID_SELECTED'] : 
	(is_numeric($arParams['SECTIONS_ID_SELECTED']) ? [$arParams['SECTIONS_ID_SELECTED']] : '');
if(!is_array($arValues)){
	$arValues = strlen($arValues) ? [$arValues] : [];
}
?>
<?if(isset($arParams['PLACEHOLDER'])):?>
	<option value=""<?if(empty($arValues)):?> selected="selected"<?endif?>><?
		print $arParams['PLACEHOLDER'];
	?></option>
<?endif?>
<?if(is_array($arParams['SECTIONS_ID'])):?>
	<?foreach($arParams['SECTIONS_ID'] as $arSection):?>
		<?
		$bSelected = in_array($arSection['ID'], $arValues);
		$arSection['TEXT'] = str_repeat('&nbsp;', ($arSection['DEPTH_LEVEL'] - 1) * 4);
		$arSection['TEXT'] .= $arSection['NAME'].' ['.$arSection['ID'].']';
		$strData = is_callable($arParams['CALLBACK_DATA']) 
			? call_user_func_array($arParams['CALLBACK_DATA'], [&$arSection]) : '';
		?>
		<option value="<?=$arSection['ID'];?>"<?if($bSelected):?> selected="selected"<?endif?> <?=$strData;?>><?
			print $arSection['TEXT'];
		?></option>
	<?endforeach?>
<?endif?>