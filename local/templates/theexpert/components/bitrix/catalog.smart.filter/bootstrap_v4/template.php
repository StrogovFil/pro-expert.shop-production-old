<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
/*
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}

$this->addExternalCss("/bitrix/css/main/font-awesome.css");
*/
$arParams["DISPLAY_ELEMENT_COUNT"] = 'N';
?>

<div id="filters_options<?= $arParams['SECTION_ID'] ?>" class="filters-options" style="display:block ">
    <? /*if (isset($arResult['FILTER_ITEMS']['APARTMENT']) && !empty($arResult['FILTER_ITEMS']['APARTMENT'])):?>
	<div class="filters-options-item">
		<a class="filters-options-item-a" href="#" data-id="apartment">
			Тип помещения
			<i class="icon icon-dropdown"></i>
		</a>
	</div>
<?endif*/ ?>
    <? /*if (isset($arResult['FILTER_ITEMS']['SIZE']) && !empty($arResult['FILTER_ITEMS']['SIZE'])):?>
	<div class="filters-options-item">
		<a class="filters-options-item-a" href="#" data-id="size">
			Размер
			<i class="icon icon-dropdown"></i>
		</a>
	</div>
<?endif*/ ?>
    <? if (isset($arResult['FILTER_ITEMS']['BRAND']) && !empty($arResult['FILTER_ITEMS']['BRAND'])): ?>
        <div class="filters-options-item">
            <a class="filters-options-item-a" href="#" data-id="brand">
                Бренд
                <i class="icon icon-dropdown"></i>
            </a>
        </div>
    <? endif ?>
	<? $strSectionCodePath = $_SERVER['REQUEST_URI'];
    if (strpos($strSectionCodePath, '/catalog/brand-') !== FALSE){ ?>
    <?}else{?>
        <? if (isset($arResult['FILTER_ITEMS']['COUNTRIES']) && !empty($arResult['FILTER_ITEMS']['COUNTRIES'])): ?>
            <div class="filters-options-item">
                <a class="filters-options-item-a" href="#" data-id="countries">
                    Страна
                    <i class="icon icon-dropdown"></i>
                </a>
            </div>
        <? endif ?>
    <?}?>
    <? if (isset($arResult['FILTER_ITEMS']['STYLE']) && !empty($arResult['FILTER_ITEMS']['STYLE'])): ?>
        <div class="filters-options-item">
            <a class="filters-options-item-a" href="#" data-id="style">
                Стиль
                <i class="icon icon-dropdown"></i>
            </a>
        </div>
    <? endif ?>
    <? if (isset($arResult['FILTER_ITEMS']['RAZDEL_MEBEL']) && !empty($arResult['FILTER_ITEMS']['RAZDEL_MEBEL'])): ?>
        <div class="filters-options-item">
            <a class="filters-options-item-a" href="#" data-id="razdel">
                Категория
                <i class="icon icon-dropdown"></i>
            </a>
        </div>
    <? endif ?>
    <? if ($arParams['FILTER_SECTION']): ?>
        <div class="filters-options-item">
            <a class="filters-options-item-a" href="#" data-id="sections">
                Категория
                <i class="icon icon-dropdown"></i>
            </a>
        </div>
    <? endif ?>
    <? /*if (isset($arResult['FILTER_ITEMS']['COLOR']) && !empty($arResult['FILTER_ITEMS']['COLOR'])):?>
	<div class="filters-options-item">
		<a class="filters-options-item-a" href="#" data-id="color">
			Цвет
			<i class="icon icon-dropdown"></i>
		</a>
	</div>
<?endif*/ ?>
    <button class="btn" onclick="window.location.href = '?set_filter=N&del_filter=Сбросить'" id="del_filter">Сбросить
    </button>
    <div id="filter_options_popup" class="filter-options-popup">
        <div id="filter_options_popup_close" class="filter-options-popup-close"></div>
        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
              method="get" class="smartfilter bx-filter-parameters-box">
            <span class="bx-filter-container-modef"></span>
            <? foreach ($arResult["HIDDEN"] as $arItem): ?>
                <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
                       value="<? echo $arItem["HTML_VALUE"] ?>"/>
            <? endforeach; ?>
            <? /*if (isset($arResult['FILTER_ITEMS']['APARTMENT']) && !empty($arResult['FILTER_ITEMS']['APARTMENT'])):?>
			<div class="filter-options-popup-apartment">
				<?printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['APARTMENT'])?>
			</div>
			<?endif?>
			<?if (isset($arResult['FILTER_ITEMS']['SIZE']) && !empty($arResult['FILTER_ITEMS']['SIZE'])):?>
			<div class="filter-options-popup-size">
				<?foreach($arResult['FILTER_ITEMS']['SIZE'] as $arFilterItemSize)
					printFilterItemByHTML($arParams['SECTION_ID'], $arFilterItemSize);?>
			</div>
			<?endif*/ ?>
            <? if (isset($arResult['FILTER_ITEMS']['BRAND']) && !empty($arResult['FILTER_ITEMS']['BRAND'])): ?>
                <div class="filter-options-popup-brand">
                    <? printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['BRAND']) ?>
                </div>
            <? endif ?>
            <? if (isset($arResult['FILTER_ITEMS']['COUNTRIES']) && !empty($arResult['FILTER_ITEMS']['COUNTRIES'])): ?>
                <div class="filter-options-popup-countries">
                    <? printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['COUNTRIES']) ?>
                </div>
            <? endif ?>
            <? if (isset($arResult['FILTER_ITEMS']['STYLE']) && !empty($arResult['FILTER_ITEMS']['STYLE'])): ?>
                <div class="filter-options-popup-style">
                    <? printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['STYLE']) ?>
                </div>
            <? endif ?>
            <? if (isset($arResult['FILTER_ITEMS']['RAZDEL_MEBEL']) && !empty($arResult['FILTER_ITEMS']['RAZDEL_MEBEL'])): ?>
                <div class="filter-options-popup-razdel">
                    <? printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['RAZDEL_MEBEL']) ?>
                </div>
            <? endif ?>
            <? if ($arParams['FILTER_SECTION']): ?>
                <div class="filter-options-popup-sections">
                    <?= showSection($arResult['FILTER_SECTIONS']) ?>
                </div>
            <? endif ?>
            <? /*if (isset($arResult['FILTER_ITEMS']['COLOR']) && !empty($arResult['FILTER_ITEMS']['COLOR'])):?>
			<div class="filter-options-popup-color">
				<?printFilterItemByHTML($arParams['SECTION_ID'], $arResult['FILTER_ITEMS']['COLOR'])?>
			</div>
			<?endif*/ ?>

            <div class="filter-options-popup-buttons">
                <input
                        class="btn btn-primary"
                        type="submit"
                        id="set_filter"
                        name="set_filter"
                        value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"
                />
                <input
                        class="btn btn-link"
                        type="submit"
                        id="del_filter"
                        name="del_filter"
                        value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
                />
                <div class="filter-popup-result" id="modef" style="display: none!important;">
                    <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                    <span class="arrow"></span>
                    <br/>
                    <a href="<? echo $arResult["FILTER_URL"] ?>"
                       target=""><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
                </div>
            </div>
            <div class="clb"></div>
        </form>
    </div>
</div>
<? //print_r($arResult["JS_FILTER_PARAMS"]);

function showSection($arSections, $depth = 0)
{
    foreach ($arSections as $section) {
        ?>

        <div class="form-check item-section-filter" data-depth="<?= $depth?>">
            <input <? if (in_array($section['ID'], $_GET['sectionId'])): ?>checked<?endif ?> type="checkbox"
                   multiple="multiple" value="<?= $section['ID'] ?>" name="sectionId[]"
                   id="section<?= $section['ID'] ?>" class="form-check-input">
            <label data-id="<?= $section['ID'] ?>" data-depth="<?= $depth ?>" data-role="label_arrFilter_26_4126748304"
                   class="form-check-label filter-section-<?= $depth ?>" for="section<?= $section['ID'] ?>">
                <?= $section['NAME'] ?></label>
        </div>
        <?php if ($section['CHILD']) {
            showSection($section['CHILD'], $depth + 1);
        }
    }

}

?>
<script type="text/javascript">
    var filterOptions<?=$arParams['SECTION_ID']?> = new JCFilterOptions('filters_options<?=$arParams["SECTION_ID"]?>');
    var smartFilter<?=$arParams['SECTION_ID']?> = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>