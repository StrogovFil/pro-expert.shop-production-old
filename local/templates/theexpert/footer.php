<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<footer class="footer">
    <div class="footer-base">
        <div class="footer-base-inner container">
            <div class="footer-base-align">
                <div class="footer-base-row">
                    <div class="footer-base-card">
                        <div class="footer-base-card-logo">
                            <a href="<?php echo ($APPLICATION->GetCurPage() === '/') ? 'javascript:void(0)' : '/'; ?>">
                                <?php
                                    $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        [
                                            "AREA_FILE_SHOW"   => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/logo_footer.php",
                                        ]
                                    );
                                ?>
                            </a>
                        </div>
                        <div class="footer-base-card-phone">
                            <?php
                                $APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"PATH" => SITE_TEMPLATE_PATH."/includes/home/phone_footer.php",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => ""
	),
	false
);
                            ?>
                        </div>
                        <div class="footer-base-card-social">
                            <?php
                                $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW"   => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/footer_social.php",
                                    )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="footer-base-menu">
                        <div class="footer-base-menu-row">
                            <?php
                                $APPLICATION->IncludeComponent(
                                    "bitrix:menu",
                                    "menu.footer",
                                    array(
                                        "ALLOW_MULTI_SELECT"    => "N",
                                        "DELAY"                 => "N",
                                        "MAX_LEVEL"             => "1",
                                        "MENU_CACHE_TIME"       => "3600",
                                        "MENU_CACHE_TYPE"       => "A",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE"        => "footer",
                                        "USE_EXT"               => "N",
                                        "MENU_THEME"            => "site",
                                    ),
                                    false
                                );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-bottom-inner container">
            <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW"   => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "PATH"             => SITE_TEMPLATE_PATH . "/includes/home/copyright.php",
                    ]
                );
            ?>
        </div>
    </div>
</footer>
</div>
<!-- Modals -->
<div class="hidden">
    <div id="addToCart" class="modal modal-buy">
        <div class="modal-header clearfix">
            <div class="modal-header-logo">
                <!-- <img src="assets/tpl/images/logo.png" alt=""> -->
            </div>
        </div>
        <div class="modal-buy-body">
            <div class="container">
                <div class="modal-buy-top clearfix">
                    <div class="modal-buy-top-pic">
                        <img src="" alt="" data-main-picture>
                    </div>
                    <div class="modal-buy-top-content">
                        <div class="h1 modal-buy-top-title">Товар добавлен в&nbsp;корзину</div>
                        <div class="h3 modal-buy-top-name" data-main-name></div>
                        <div class="modal-buy-data">
                            <div class="modal-buy-data-top">
                                <div class="modal-buy-data-price"><span data-main-price></span> ₽</div>
                                <div class="modal-buy-data-count js-count">
                                    <span class="modal-buy-data-count-btn js-count-btn minus" role="button">
                                        <i class="icon icon-angle-left"></i>
                                    </span>
                                    <input type="text" name="count" title="" value="1" class="modal-buy-data-count-input js-count-input" data-main-count>
                                    <span class="modal-buy-data-count-btn js-count-btn plus" role="button">
                                        <i class="icon icon-angle-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-buy-data-bottom">
                                <a href="" class="btn">Перейти в корзину</a>
                                <a href="javascript:" class="btn btn-black" onclick="$.fancybox.close();">Продолжить покупки</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-buy-bottom">
                    <div class="h1 modal-buy-bottom-title hidden" data-add-title>С этим товаром покупают</div>
                    <div class="modal-buy-bottom-filters">
                        <a href="" class="active">Самые популярные</a>
                        <a href="">Освещение</a>
                        <a href="">Уличное окружение</a>
                    </div>
                    <div class="modal-buy-linked clearfix" data-add-linked></div>
                    <div class="modal-buy-bottom-inform" data-add-inform></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Modals -->
</body>
</html>
