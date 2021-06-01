<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Sale;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$basketItems = $basket->getBasketItems();
foreach ($basket as $basketItem) {
    $basketItemsNames .= $basketItem->getField('NAME').'; ';
}

$event = new CEvent;
$event->Send("NEW_ORDER_BASKET", SITE_ID, array("NAME" => $_POST['name'], "PHONE" => $_POST['phone'], "MAIL" => $_POST['mail'], "ORDER" => $basketItemsNames), "N");

echo "Спасибо за Ваш запрос!";