<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

    if (!empty($arResult)): ?>
        <ul class="footer-base-menu-list">
        <?php foreach ($arResult as $key => $item): ?>
            <?php if (($key % 4) == 0 && $key !== 0): ?></ul><ul class="footer-base-menu-list"><?php endif; ?>
            <li><a href="<?php echo $item['LINK']; ?>"><?php echo $item['TEXT']; ?></a></li>
        <?php endforeach; ?>
        </ul>
    <? endif; ?>
