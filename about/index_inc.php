<section class="page">
        <div class="page-top" style="background-image: url('<?=SITE_TEMPLATE_PATH?>/images/about.jpg');" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5" data-image-src="<?=SITE_TEMPLATE_PATH?>/images/about_company3.jpg">
            <div class="container">
                <h1 class="h1 page-top-title">О компании</h1>
                <div class="page-top-text">ProExpert оказывает услуги проектирования, строительства, инженерного оснащения и комплектации внутренних помещений объектов жилой и коммерческой недвижимости.</div>
            </div>
        </div>
        <div class="about">
            <div class="container">
                <div class="page-textblock">
                    <div class="container-inner about-decorated-1">
                        <p>ProExpert Shop – онлайн-каталог с широкой ассортиментной матрицей товаров ведущих мировых производителей мебели, комплектующих и отделочных материалов.</p>
                    </div>
                </div>
            </div>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "slides_about", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"DISPLAY_DATE" => "Y",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "12",	// Код информационного блока
		"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "20",	// Количество новостей на странице
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "MORE_PHOTO",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_BY2" => "ID",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"STRICT_SECTION_CHECK" => "Y",	// Строгая проверка раздела для показа списка
	),
	false
);?>
            <div class="container">
                <div class="page-textblock">
                    <div class="container-inner">
                        <div class="h1">Партнерские отношения и&nbsp;опыт сотрудничества</div>
                        <p>Налаженные связи и долгосрочные отношения с производителями США, Европы и Азии стали основой для создания масштабного каталога, включающего более 10 000 коллекций различных брендов для комплектации интерьеров.</p>
                    </div>
                </div>
                <div class="about-icons">
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/presentation.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/presentation.png'">
                        </div>
                        <div class="about-icons-item-title">20-летний опыт работы в сфере комплектации</div>
                    </div>
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/idea.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/idea.png'">
                        </div>
                        <div class="about-icons-item-title">Работа напрямую с более чем 150 производителями</div>
                    </div>
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/delivery-man.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/delivery-man.png'">
                        </div>
                        <div class="about-icons-item-title">Выстроенная система логистики товаров</div>
                    </div>
                </div>
            </div>
            <img src="<?=SITE_TEMPLATE_PATH?>/images/about-1.jpg" alt="" class="page-image">
            <div class="container">
                <div class="page-textblock">
                    <div class="container-inner about-decorated-2">
                        <div class="h1">Комплектация объектов любых типов недвижимости</div>
                         <p>В каталоге ProExpert Shop представлены товары для создания и реализации интерьерных проектов во всех типах недвижимости: жилые помещения, апартаменты и отели, офисные пространства, торговые, производственные и складские площади, спортивные, образовательные и медицинские учреждения, театры и кинотеатры, конгресс-центры и конференц-залы, вокзалы и аэропорты, кафе и рестораны, банки и автосалоны.</p>
                    </div>
                </div>
            </div>
            <img src="<?=SITE_TEMPLATE_PATH?>/images/about-2.jpg" alt="" class="page-image">
            <div class="container">
                <div class="page-textblock">
                    <div class="container-inner">
                       
                        <div class="h1">Экономия бюджета на комплектацию проекта</div>
                        <p>Выбирая продукцию на ProExpert Shop, вы получаете минимально возможные цены благодаря эксклюзивным партнерским условиям, прямым поставкам и скидкам за объем.</p>
                    </div>
                </div>
                <div class="about-icons">
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/calendar.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/calendar.png'">
                        </div>
                        <div class="about-icons-item-title">Сокращение сроков поставки товаров</div>
                    </div>
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/get-money.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/get-money.png'">
                        </div>
                        <div class="about-icons-item-title">Партнерские скидки на продукцию</div>
                    </div>
                    <div class="about-icons-item">
                        <div class="about-icons-item-icon">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/analytics.svg" alt=""
                                 onerror="this.onerror = null; this.src = '<?=SITE_TEMPLATE_PATH?>/images/icons/analytics.png'">
                        </div>
                        <div class="about-icons-item-title">Комплектация проекта "под ключ"</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Question -->
    <section class="question question-dark" data-bleed="100" data-parallax="scroll" data-z-index="1" data-speed="0.5" data-image-src="<?=SITE_TEMPLATE_PATH?>/images/form-bg.jpg">
        <div class="container">
            <div class="question-header">
                <div class="h2 question-title">Задать вопрос</div>
                <div class="question-text">Оставьте ваши контактные данные, и наш менеджер обязательно проконсультирует вас по всем вопросам</div>
            </div>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"form_1",
	Array(
'AJAX_MODE' => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID",),
		"WEB_FORM_ID" => "1"
	)
);?>
        </div>
    </section>
    <!--/ Question -->

    <section class="team">
        <div class="container">
            <div class="team-header">
                <div class="h1 team-header-title">продукция</div>
                <div class="h2 team-header-small">дизайнеров со всего мира</div>
                <a href="/dizaynery/" class="btn">Дизайнеры</a>
            </div>
            <?/*$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"workers",
	Array(
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
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"POST",1=>"EMAIL",2=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y"
	)
);*/?>
            <div class="about-clients">
                <div class="h1 about-clients-title container-inner">Наши клиенты</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"clients",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y"
	)
);?>
            </div>
        </div>
    </section>