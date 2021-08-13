<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
			$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
			$theme = COption::GetOptionString("main", "wizard_".$templateId."_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";*/

if (!isset($arParams['NOT_INCLUDE']))
	$arParams['NOT_INCLUDE'] = array();

$arResult['FILTER_ITEMS'] = array();

foreach($arResult["ITEMS"] as $arFilterItem)
{
	if (isset($arParams['NOT_INCLUDE']) && in_array($arFilterItem['CODE'], $arParams['NOT_INCLUDE']))
		continue;





	switch($arFilterItem['CODE'])
	{
		// case 'SIZE_X':
		// case 'SIZE_Y':
		// case 'SIZE_Z':
		// 	$arResult['FILTER_ITEMS']['SIZE'][] = $arFilterItem;
		// 	break;
		// case 'COLOR':
		// 	$arResult['FILTER_ITEMS']['COLOR'] = $arFilterItem;
		// 	break;
		case 'BRAND':
            global $arrFilter;
            $brand = [];

            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FUNCTIONAL", "PROPERTY_BRAND", "PROPERTY_COUNTRIES", "PROPERTY_APARTMENT");
            $arFilter = Array("IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE" => "Y", "PROPERTY_BRAND" => $arrFilter['PROPERTY_27'], "PROPERTY_APARTMENT" => $arParams['SECTION_FILTER_ID']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                if(!in_array($arFields['PROPERTY_BRAND_VALUE'], $brand)) {
                    $brand[] = $arFields['PROPERTY_BRAND_VALUE'];
                }
            }

            foreach($arFilterItem['VALUES'] as $key => $value) {
                if(!in_array($key, $brand)) {
                    unset($arFilterItem['VALUES'][$key]);
                } else {
                    $arFilterItem['VALUES'][$key] = $value;
                }
            }
            $arResult['FILTER_ITEMS']['BRAND'] = $arFilterItem;
            break;
		case 'COUNTRIES':
            global $arrFilter;
            $countries = [];

            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FUNCTIONAL", "PROPERTY_BRAND", "PROPERTY_COUNTRIES", "PROPERTY_APARTMENT");
            $arFilter = Array("IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE" => "Y", "PROPERTY_BRAND" => $arrFilter['PROPERTY_27'], "PROPERTY_APARTMENT" => $arParams['SECTION_FILTER_ID']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                if(!in_array($arFields['PROPERTY_COUNTRIES_VALUE'], $countries)) {
                    $countries[] = $arFields['PROPERTY_COUNTRIES_VALUE'];
                }
            }

            foreach($arFilterItem['VALUES'] as $key => $value) {
                if(!in_array($key, $countries)) {
                    unset($arFilterItem['VALUES'][$key]);
                } else {
                    $arFilterItem['VALUES'][$key] = $value;
                }
            }
            $arResult['FILTER_ITEMS']['COUNTRIES'] = $arFilterItem;
            break;
		case 'STYLE':
//			$arResult['FILTER_ITEMS']['STYLE'] = $arFilterItem;
//			break;
		case 'RAZDEL_MEBEL':
			$arResult['FILTER_ITEMS']['RAZDEL_MEBEL'] = $arFilterItem;
			break;
		case 'APARTMENT':
			$arResult['FILTER_ITEMS']['APARTMENT'] = $arFilterItem;
			break;
		case 'FUNCTIONAL':
            global $arrFilter;
            $functional = [];

            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FUNCTIONAL", "PROPERTY_BRAND");
            $arFilter = Array("IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE" => "Y", "PROPERTY_BRAND" => $arrFilter['PROPERTY_27']);
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                if(!in_array($arFields['PROPERTY_FUNCTIONAL_VALUE'], $functional)) {
                    $functional[] = $arFields['PROPERTY_FUNCTIONAL_VALUE'];
                }
            }

            foreach($arFilterItem['VALUES'] as $key => $value) {
                if(!in_array($key, $functional)) {
                    unset($arFilterItem['VALUES'][$key]);
                } else {
                    $arFilterItem['VALUES'][$key] = $value;
                }
            }
			$arResult['FILTER_ITEMS']['FUNCTIONAL'] = $arFilterItem;
            break;
	}
}

if($arParams['FILTER_SECTION']) {
    global $arrFilter;
    $arSections = [];

    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FUNCTIONAL", "PROPERTY_BRAND", "PROPERTY_APARTMENT", "IBLOCK_SECTION_ID");
    $arFilter = Array("IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE" => "Y", "PROPERTY_BRAND" => $arrFilter['PROPERTY_27'], "PROPERTY_APARTMENT" => $arParams['SECTION_FILTER_ID']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arSections[] = $arFields['IBLOCK_SECTION_ID'];
    }

    $rsSections = CIBlockSection::GetList(['DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC'], ['IBLOCK_ID' => 1], false, ['IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID']);

    $sectionLinc = array();
    while ($arSection = $rsSections->GetNext()) {
        $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
        $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
    }
    $sectionLinc = $sectionLinc[0]['CHILD'];
    $arResult['FILTER_SECTIONS'] = getMeNecessarySections($sectionLinc, $arSections);
}

function getMeNecessarySections($sectionTree, $sections) {
    foreach($sectionTree as $sectionId => $section)
    {
        if(!in_array($sectionId, $sections) && !$section['CHILD']) {
            unset ($sectionTree[$sectionId]);
        }
        elseif($section['CHILD']) {
            $section['CHILD'] = getMeNecessarySections($section['CHILD'], $sections);
            if(empty($section['CHILD'])) {
                unset($sectionTree[$sectionId]);
            }
            else {
                $sectionTree[$sectionId]['CHILD'] = $section['CHILD'];
            }
        }
    }
    return $sectionTree;

}
