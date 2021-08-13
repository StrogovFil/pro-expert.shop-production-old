<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager,
    Bitrix\Iblock;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */
?>

<script src="//jssors8.azureedge.net/script/jssor.slider-27.5.0.min.js" type="text/javascript"></script>

<?if (isset($arResult['VARIABLES']['SECTION_CODE']) && !empty($arResult['VARIABLES']['SECTION_CODE']))
    $strSectionCodePath = $arResult['VARIABLES']['SECTION_CODE'];
elseif (isset($arResult['VARIABLES']['SECTION_CODE_PATH']) && !empty($arResult['VARIABLES']['SECTION_CODE_PATH']))
    $strSectionCodePath = $arResult['VARIABLES']['SECTION_CODE_PATH'];
else
    $strSectionCodePath = '';

$filterSection = false;
$filterType = true;
if ($strSectionCodePath)
{
    if (strpos($strSectionCodePath, 'place-') !== FALSE)
    {
        $strSectionCode = str_replace('place-', '', $strSectionCodePath);
        $iBlockId = 2;
        $filterType = false;
        $filterSection = true;
    }
    elseif (strpos($strSectionCodePath, 'brand-') !== FALSE)
    {
        $strSectionCode = str_replace('brand-', '', $strSectionCodePath);
        $iBlockId = 11;
        $filterSection = true;
    }
    else
    {
        $iBlockId = 1;
        $strSectionCode = $strSectionCodePath;
    }
}
else
    $iBlockId = 0;

if ($iBlockId)
{
    $arFilter = array(
        'ACTIVE' => 'Y',
        'CODE' => $strSectionCode,
        'GLOBAL_ACTIVE' => 'Y',
        'IBLOCK_ID' => $iBlockId
    );

    if ($iBlockId > 1)
    {
        $res = CIBlockElement::GetList(
            array("SORT"=>"ASC"),
            $arFilter,
            false,
            false,
            array()
        );
    }
    elseif ($iBlockId == 1)
    {
        $res = CIBlockSection::GetList(
            array("SORT"=>"ASC"),
            $arFilter,
                true,array("UF_*")
        );
    }

    $arFields = $res->Fetch();
}

if (empty($arFields))
{
    Iblock\Component\Tools::process404(
        trim($arParams["MESSAGE_404"]),
        true,
        "Y",
        "Y",
        $arParams["FILE_404"]
    );
}

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
    $basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
    $basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}
?>
    <nav class="breadcrumb-wrap bread-sticky">
        <div class="container box-sticky">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "catalog",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            );?>
        </div>
    </nav>
<? if (!empty($arFields) && $iBlockId > 1)
{
    $APPLICATION->IncludeComponent("bitrix:news.detail", "catalog_brand_place", Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",    // Формат показа даты
            "ADD_ELEMENT_CHAIN" => "Y", // Включать название элемента в цепочку навигации
            "ADD_SECTIONS_CHAIN" => "N",    // Включать раздел в цепочку навигации
            "AJAX_MODE" => "N", // Включить режим AJAX
            "AJAX_OPTION_ADDITIONAL" => "", // Дополнительный идентификатор
            "AJAX_OPTION_HISTORY" => "N",   // Включить эмуляцию навигации браузера
            "AJAX_OPTION_JUMP" => "N",  // Включить прокрутку к началу компонента
            "AJAX_OPTION_STYLE" => "Y", // Включить подгрузку стилей
            "BROWSER_TITLE" => "NAME",  // Установить заголовок окна браузера из свойства
            "CACHE_GROUPS" => "Y",  // Учитывать права доступа
            "CACHE_TIME" => "36000000", // Время кеширования (сек.)
            "CACHE_TYPE" => "A",    // Тип кеширования
            "CHECK_DATES" => "Y",   // Показывать только активные на данный момент элементы
            "DETAIL_URL" => "", // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
            "DISPLAY_BOTTOM_PAGER" => "N",  // Выводить под списком
            "DISPLAY_DATE" => "Y",  // Выводить дату элемента
            "DISPLAY_NAME" => "Y",  // Выводить название элемента
            "DISPLAY_PICTURE" => "Y",   // Выводить детальное изображение
            "DISPLAY_PREVIEW_TEXT" => "Y",  // Выводить текст анонса
            "DISPLAY_TOP_PAGER" => "N", // Выводить над списком
            "ELEMENT_CODE" => $arFields["CODE"],    // Код новости
            "ELEMENT_ID" => $arFields["ELEMENT_ID"],    // ID новости
            "FIELD_CODE" => array(  // Поля
                0 => "PREVIEW_PICTURE",
                1 => "",
            ),
            "IBLOCK_ID" => $arFields['IBLOCK_ID'],  // Код информационного блока
            "IBLOCK_TYPE" => "catalog", // Тип информационного блока (используется только для проверки)
            "IBLOCK_URL" => "", // URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Включать инфоблок в цепочку навигации
            "META_DESCRIPTION" => "-",  // Установить описание страницы из свойства
            "META_KEYWORDS" => "-", // Установить ключевые слова страницы из свойства
            "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
            "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
            "PAGER_TEMPLATE" => "modern",   // Шаблон постраничной навигации
            "PAGER_TITLE" => "Страница",    // Название категорий
            "PROPERTY_CODE" => array(   // Свойства
                0 => "",
                1 => "",
            ),
            "SET_BROWSER_TITLE" => "Y", // Устанавливать заголовок окна браузера
            "SET_CANONICAL_URL" => "N", // Устанавливать канонический URL
            "SET_LAST_MODIFIED" => "N", // Устанавливать в заголовках ответа время модификации страницы
            "SET_META_DESCRIPTION" => "N",  // Устанавливать описание страницы
            "SET_META_KEYWORDS" => "N", // Устанавливать ключевые слова страницы
            "SET_TITLE" => "Y", // Устанавливать заголовок страницы
            "STRICT_SECTION_CHECK" => "N",  // Строгая проверка раздела для показа элемента
            "USE_PERMISSIONS" => "N",   // Использовать дополнительное ограничение доступа
            "USE_SHARE" => "N", // Отображать панель соц. закладок
            "CATALOG_PARAMS" => $arParams,
            "MESSAGE_404" => $arParams["~MESSAGE_404"],
            'FILTER_TYPE' => $filterType,
        //"SET_STATUS_404" => $arParams["SET_STATUS_404"],
        //"SHOW_404" => $arParams["SHOW_404"],
        //"FILE_404" => $arParams["FILE_404"]
        ),
        false
    );
}
elseif (!empty($arFields) && $iBlockId == 1)
{
    if (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'price'){
        $arParams['ELEMENT_SORT_FIELD'] = 'catalog_PRICE_1';
    }elseif (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'name') {
        $arParams['ELEMENT_SORT_FIELD'] = 'name';
    }elseif (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'id') {
        $arParams['ELEMENT_SORT_FIELD'] = 'id';
    }

    if (isset($_REQUEST['order']))
    {
        if ($_REQUEST['order'] == 'DESC')
            $strOrder = 'ASC';
        else
            $strOrder = 'DESC';

        $arParams["ELEMENT_SORT_ORDER"] = $_REQUEST['order'];
    }
    else
        $strOrder = 'ASC';

    $res = CIBlockSection::GetList(
        array(),
        array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'CODE' => $arResult["VARIABLES"]["SECTION_CODE"]),
        false,
        array('ID', 'IBLOCK_ID', 'CODE', 'IBLOCK_SECTION_ID', 'NAME', 'PICTURE', 'DESCRIPTION', 'DESCRIPTION_TYPE', 'DETAIL_PICTURE', 'UF_*')
    );

    $arSection = $res->Fetch();

    /*if ($arSection["PICTURE"])
    {
        $dbIBlockPicture = CFile::GetByID($arSection["PICTURE"]);
        $arSectionPicture = $dbIBlockPicture->GetNext();
        $pathIblockPicture = CFile::GetPath($arSection["PICTURE"]);
}*/

    if ($arSection["DETAIL_PICTURE"])
    {
        $dbIBlockPicture = CFile::GetByID($arSection["DETAIL_PICTURE"]);
        $arSectionDetailPicture = $dbIBlockPicture->GetNext();
        $pathIblockDetailPicture = CFile::GetPath($arSection["DETAIL_PICTURE"]);
    }

    $cnt = CIBlockSection::GetSectionElementsCount($arSection["ID"]);
?><!-- The Modal -->
    <span class="close">&times;</span>
    <div id="myModal" class="modal owl-carousel" <?=count($arFields["UF_GALLERY"]) > 1 ? 'data-loop="true"' : 'data-loop="false"'?>>
        <!-- The Close Button -->
        <!-- Modal Content (The Image) -->
        <?
        if($arFields["UF_GALLERY"]){
            foreach ($arFields["UF_GALLERY"] as $key => $v)
            {
                ?>
                <img style="max-height: 415px;width:auto;" class="owl-item-my modal-content" src="<?=CFile::GetPath($v)?>">
                <?
            }
        }elseif ($arSection["PICTURE"]){?>
            <img class="owl-item-my modal-content" style="min-width: 423px; width:auto; min-height: 423px; max-height: 415px;" src="<?=CFile::GetPath($arSection["PICTURE"])?>"/>
        <?}?>
    </div>
    <section class="page catalog">
            <?if($arFields["UF_GALLERY"]){?>
            <div class="container">
                <div class="product-top-images col-6" style="float: left">
                    <div class="product-top-images-inner">
                        <div class="product-top-images-main" style="min-width: 423px; min-height: 423px">
                            <div id="galleryMain" class="owl-carousel" style="min-width: 423px; min-height: 423px">
                                <?
                                if($arFields["UF_GALLERY"]){
                                    foreach ($arFields["UF_GALLERY"] as $key => $v)
                                    {
                                        ?>
                                        <img class="owl-item-my" src="<?=CFile::GetPath($v)?>">
                                        <?
                                    }
                                }elseif ($arSection["PICTURE"]){?>
                                    <div class="topblock-header-icon">
                                        <img  style="min-width: 423px; min-height: 423px" src="<?=CFile::GetPath($arSection["PICTURE"])?>"/>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                        <div class="product-top-images-thumb">
                            <div id="galleryThumbs" class="owl-carousel">
                                <?if($arFields["UF_GALLERY"]){
                                    foreach ($arFields["UF_GALLERY"] as $key => $v)
                                    {
                                        ?>
                                        <img src="<?=CFile::GetPath($v)?>">
                                        <?
                                    }
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
            <?}else{?>
            <div class="topblock catalog-top col-6" style="float:left; width:50%">
                <?if ($arSection["DETAIL_PICTURE"]):?>

                    <div class="topblock-pic" style="background-image: url('<?=$pathIblockDetailPicture?>">
                        <img src="<?=CFile::GetPath($arSection["DETAIL_PICTURE"])?>" width="<?=$arSectionDetailPicture['WIDTH']?>" height="<?=$arSectionDetailPicture['HEIGHT']?>" alt="">
                    </div>
                <?else:?>
                    <div class="topblock-pic"></div>
                <?endif?>
            </div>
            <?}?>
            <div class="topblock catalog-top col-6" style="float:left; width:50%">
                <div class="topblock-content">
                    <div class="topblock-content-inner">
                        <div class="topblock-header topblock-header-graphic">
                            <?/*if ($arSection["PICTURE"]):?>
                            <div class="topblock-header-icon">
                                <img src="<?=$pathIblockPicture?>" width="<?=$arSectionPicture['WIDTH']?>" height="<?=$arSectionPicture['HEIGHT']?>" alt=""
                                     onerror="this.onerror = null; this.src = '<?=$pathIblockPicture?>'">
                            </div>
                            <?else:?>
                            <div class="topblock-header-icon"></div>
                            <?endif*/?>
                            <h1 class="h3 topblock-title"><?=$arSection['NAME']?></h1>
<!--                            <div class="topblock-header-note">Всего --><?//=$cnt?><!--</div>-->
                        </div>
                        <div class="topblock-text"><?=$arSection['DESCRIPTION']?></div>
                        <hr>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:catalog.section.list",
                            "",
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "COUNT_ELEMENTS" => "Y",
                                "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                                "ADD_SECTIONS_CHAIN" => "Y"
                            ),
                            $component,
                            array("HIDE_ICONS" => "Y")
                        );?>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-items-bordered container catalog-container-page">
            <? if ($isFilter && !$arFields["UF_COLLECTION"]): ?>
            <div class="filters catalog-filters">
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.smart.filter",
                    "bootstrap_v4",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arCurSection['ID'],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "PRICE_CODE" => '',//$arParams["~PRICE_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SAVE_IN_SESSION" => "N",
                        "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                        "XML_EXPORT" => "N",
                        "SECTION_TITLE" => "NAME",
                        "SECTION_DESCRIPTION" => "DESCRIPTION",
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        "SEF_MODE" => 'N',//$arParams["SEF_MODE"],
                        "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                        "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                        'DISPLAY_ELEMENT_COUNT' => 'N',
                        'FILTER_SECTION' => $filterSection,
                        'FILTER_TYPE' => $filterType,
                        //'SECTION_FILTER_ID' => $arSection['ID']
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
                
                <div class="filters-sort-wrap">
                    <?$page = $APPLICATION->GetCurUri();?>
                    <div class="show-block-wrap">
                        <div class="show-block-title">Показать по:</div>
                        <div class="show-block-war">
                            <a class="pagen-size<?if(strstr($page, 'SIZEN_1=30') !== false || strstr($page, 'SIZEN_1') === false):?> is-active<?endif?>" href="<?=$APPLICATION->GetCurPageParam("SIZEN_1=30", array("SIZEN_1"));?>">30</a>  /
                            <a class="pagen-size<?if(strstr($page, 'SIZEN_1=50') !== false):?> is-active<?endif?> js-cat-page-count" href="<?=$APPLICATION->GetCurPageParam("SIZEN_1=50", array("SIZEN_1"));?>">50</a> /
                            <a class="pagen-size<?if(strstr($page, 'SIZEN_1=100') !== false):?> is-active<?endif?> js-cat-page-count" href="<?=$APPLICATION->GetCurPageParam("SIZEN_1=100", array("SIZEN_1"));?>">100</a>
                        </div>
                    </div>

                    <?$sort = $_GET['sort'];?>
                    <div class="filters-sort js-filters-sort" data-sort="<?if($sort){?>true<?}else{?>false<?}?>">
                        Сортировать:&emsp;
                        <?if($_REQUEST['order'] == ''):?>
                            <a href="?sort=name&order=DESC" class="filter-sort-ASC filter-sort-item filter-sort-active">A - Z <i class="icon icon-dropdown"></i></a>
                        <?elseif($strOrder == 'ASC'):?>
                            <a href="?sort=name&order=ASC" class="filter-sort-DESC filter-sort-item filter-sort-active">Z - A <i class="icon icon-dropdown"></i></a>
                        <?elseif($strOrder == 'DESC'):?>
                            <a href="?sort=name&order=DESC" class="filter-sort-ASC filter-sort-item filter-sort-active">A - Z <i class="icon icon-dropdown"></i></a>
                        <?endif?>
                        <?/*<a href="?sort=id&order=<?=$strOrder?>" class="filter-sort-<?=$strOrder?> filter-sort-item <?if($_REQUEST['sort'] == 'id'){?>filter-sort-active<?}?>">по новизне <i class="icon icon-dropdown"></i></a>*/?>
                        <?/*<a href="?sort=price&order=<?=$strOrder?>" class="filter-sort-<?=$strOrder?> filter-sort-item <?if($_REQUEST['sort'] == 'price'){?>filter-sort-active<?}?>">по цене <i class="icon icon-dropdown"></i></a>*/?>
                    </div>
                </div>
            </div>
        <? endif ?>
            <?
            if($arFields["UF_COLLECTION"]){
                $APPLICATION->SetTitle($arFields["NAME"]);
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "collection",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "COUNT_ELEMENTS" => "Y",
                        "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                        "VIEW_MODE" => "TILE",
                        "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                        "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                        "ADD_SECTIONS_CHAIN" => "N"
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );
            }else {
                $intSectionID = $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                        "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
                        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                        "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "SET_TITLE" => $arParams["SET_TITLE"],
                        "MESSAGE_404" => $arParams["~MESSAGE_404"],
                        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                        "SHOW_404" => $arParams["SHOW_404"],
                        "FILE_404" => $arParams["FILE_404"],
                        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                        "PRICE_CODE" => $arParams["~PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                        "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                        "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
                        "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                        "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                        'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                        'HIDE_SECTION_DESCRIPTION' => 'Y',

                        'LABEL_PROP' => $arParams['LABEL_PROP'],
                        'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
                        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
                        'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                        'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                        'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                        'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                        'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                        'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                        'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                        'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                        'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                        'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                        'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                        'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                        'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                        'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                        'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                        'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                        "ADD_SECTIONS_CHAIN" => "N",
                        'ADD_TO_BASKET_ACTION' => $basketAction,
                        'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                        'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
                        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
                        'USE_COMPARE_LIST' => 'Y',
                        'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                        'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
                        'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
                    ),
                    $component
                );
            }
            ?>
        </div>
    </section>
<?}?>
<?//$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;?>
<?/*$APPLICATION->IncludeComponent("bitrix:news.list", "catalog_news", array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "/#IBLOCK_CODE#/#SECTION_CODE#/#CODE#/",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "10",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "1",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "120",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESIGNERS",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "RAND",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);*/?>

<?if($arResult['VARIABLES']['SECTION_ID']):?>
    <?$sectionAddBlockTitle = '';
    $sectionAddBlockDesc = '';
    $arSelect = Array('ID', 'NAME', 'UF_*' );
    $arFilter = Array('IBLOCK_ID' => $arFields['IBLOCK_ID'], 'GLOBAL_ACTIVE' => 'Y', 'ID' => $arResult['VARIABLES']['SECTION_ID']);
    $dbList = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect);
    while($ar_result = $dbList->GetNext()) {
        $sectionAddBlockTitle = $ar_result['UF_TITLE_ADDBLOCK'];
        $sectionAddBlockDesc = $ar_result['UF_DESC_ADDBLOCK'];
    }?>
<?endif?>

<?if(!empty($sectionAddBlockDesc)):?>
    <section class="insert">
        <div class="insert-inner container">
            <div class="container-inner">
                <?if(!empty($sectionAddBlockTitle)):?>
                    <div class="h1 insert-title color-orange"><?=$sectionAddBlockTitle?></div>
                <?endif?>
                <?if(!empty($sectionAddBlockDesc)):?>
                    <div class="insert-text">
                        <p><?=$sectionAddBlockDesc?></p>
                    </div>
                <?endif?>
            </div>
        </div>
    </section>
<?endif?>

<?/*
if (!count($arFields))
{
    $dbSections = CIBlockSection::GetList(
        Array(),
        Array(
            'IBLOCK_ID' => $arParams["IBLOCK_ID"],
            'SECTION_ID' => 0,
            'ACTIVE' => 'Y',
            'GLOBAL_ACTIVE' => 'Y'
        )
    );

    $bRes = true;

    while ($obElement = $dbSections->GetNext())
    {
        if ($obElement["ID"] != $intSectionID['ID'] && $bRes)
            $arSection = $obElement;
        else
            $bRes = false;
    }

    if (!empty($arSection)):
        $sectCnt = CIBlockSection::GetSectionElementsCount($arSection['ID']);
        $pathPicture = CFile::GetPath($arSection['PREVIEW_PICTURE']);
?>
    <section class="bottomblock" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5" data-image-src="<?=SITE_TEMPLATE_PATH?>/images/bottom-block-1.jpeg " style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/bottom-block-1.jpeg ');">
        <div class="container">
            <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="bottomblock-icon">
                <img src="<?=pathPicture?>" alt="" onerror="this.onerror = null; this.src = '<?=pathPicture?>'">
            </a>
            <div class="h1 bottomblock-title"><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a></div>
            <div class="bottomblock-note">Всего <?=$sectCnt?></div>
            <div class="bottomblock-text">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "",
                    Array(
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COUNT_ELEMENTS" => "N",
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "SECTION_CODE" => "",
                        "SECTION_FIELDS" => array("",""),
                        "SECTION_ID" => $arSection['ID'],
                        "SECTION_URL" => "/#IBLOCK_CODE#/#CODE#/",
                        "SECTION_USER_FIELDS" => array("",""),
                        "SHOW_PARENT_NAME" => "N",
                        "TOP_DEPTH" => "1",
                        "VIEW_MODE" => "TEXT"
                    )
                );?>
            </div>
            <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="bottomblock-triangle">
                <i class="icon icon-triangle-down"></i>
            </a>
        </div>
    </section>
<?  endif;
}*/?>
