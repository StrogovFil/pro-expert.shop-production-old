<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
        die();
    }
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\Page\Asset;
    Loc::loadMessages(__FILE__);
?>
<!doctype html>
<html lang="<?php echo LANGUAGE_ID; ?>">
<head>
    <!-- All-devices friendly block -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--suppress CssInvalidPropertyValue -->
    <style>
        @-webkit-viewport {
            width: device-width;
        }

        @-moz-viewport {
            width: device-width;
        }

        @-ms-viewport {
            width: device-width;
        }

        @-o-viewport {
            width: device-width;
        }

        @viewport {
            width: device-width;
        }
    </style>
    <script>
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style');
            msViewportStyle.appendChild(document.createTextNode('@-ms-viewport { width: auto! important }'));
            document.querySelector('head').appendChild(msViewportStyle);
        }
    </script>
    <!--/ All-devices friendly block -->
    <title><?php echo $APPLICATION->ShowTitle(); ?></title>
    <?php
        // Подключение CSS
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/css/style_2.css');
        // Подключение JS
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery-2.2.4.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.superslides.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.touchwipe.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.scroll.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/owl.carousel.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/easyzoom.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/parallax.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.maskedinput.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.fancybox.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/btn-up.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/jquery.cookie.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/script.js');
        $APPLICATION->ShowHead();
    ?>
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>
<div class="fon_input"></div>
<div class="allwrap">
    <header id="header" class="header">
        <div class="header-top">
            <div class="header-top-inner clearfix">
                <div class="header-top-phone">
                    <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW"   => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/phone.php",
                            ]
                        );
                    ?>
                </div>
                <form class="form-header-input" action="/search/index.php">
                    <div class="header_input_search">
                        <div class="input-group-search">
                            <input class="header_input" type="text" placeholder="" name="q">
                            <div class="search_input_close"><i class="icon icon-menu-close"></i></div>
                            <button type="submit" class="search_ikon header-top-icons-search"><i class="icon icon-search"></i></button>
                        </div>
                    </div>
                </form>
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.basket.basket.line",
					"header",
					Array(
						"HIDE_ON_BASKET_PAGES" => "Y",
						"PATH_TO_AUTHORIZE" => "",
						"PATH_TO_BASKET" => SITE_DIR."personal/request/",
						"PATH_TO_ORDER" => SITE_DIR."personal/order/",
						"PATH_TO_PERSONAL" => SITE_DIR."personal/",
						"PATH_TO_PROFILE" => SITE_DIR."personal/",
						"PATH_TO_REGISTER" => SITE_DIR."login/",
						"POSITION_FIXED" => "N",
						"SHOW_AUTHOR" => "N",
						"SHOW_EMPTY_VALUES" => "Y",
						"SHOW_NUM_PRODUCTS" => "Y",
						"SHOW_PERSONAL_LINK" => "N",
						"SHOW_PRODUCTS" => "N",
						"SHOW_REGISTRATION" => "N",
						"SHOW_TOTAL_PRICE" => "Y"
					)
				);?>
                <div class="header-top-icons">
                    <a href="javascript:void(0)" class="header-top-icons-search">
                        <i class="icon icon-search"></i>
                    </a>
                    <a href="" class="header-top-icons-user">
                        <i class="icon icon-user"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-base">
            <div class="header-base-inner container">
                <div class="header-base-logo">
                    <a href="/">
                        <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW"   => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/logo.php",
                                ]
                            );
                        ?>
                    </a>
                </div>
                <div class="header-menu header-base-menu">
                    <a href="javascript:void(0); " class="header-menu-trigger">
                        <i class="icon icon-menu"></i>
                    </a>
                    <nav class="header-menu-container">
                        <a href="javascript:void(0); " class="header-menu-close">
                            <i class="icon icon-menu-close"></i>
                        </a>
                        <form class="form-header-input mobile-form" action="/search/index.php">
                            <div class="header_input_search">
                                <div class="input-group-search">
                                    <span class="search--icon"><i class="icon icon-search"></i></span>
                                    <input class="header_input" type="text" placeholder="" name="q">
                                    <div class="search_input_close"><i class="icon icon-menu-close"></i></div>
                                    <button type="submit" class="search_ikon header-top-icons-search"><i class="icon icon-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <?php
                            $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "menu.header",
                                [
                                    "ALLOW_MULTI_SELECT"    => "N",
                                    "DELAY"                 => "N",
                                    "MAX_LEVEL"             => "2",
                                    "CHILD_MENU_TYPE"       => "child",
                                    "MENU_CACHE_TIME"       => "3600",
                                    "MENU_CACHE_TYPE"       => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE"        => "top",
                                    "USE_EXT"               => "Y",
                                ],
                                false
                            );
                        ?>
                        <div class="header-menu-phone">
                            <?php
                                $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW"   => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/phone.php",
                                    ]
                                );
                            ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

