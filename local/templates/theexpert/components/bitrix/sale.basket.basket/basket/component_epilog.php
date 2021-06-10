<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->get('clear') !== null && Loader::includeModule("sale")) {
    CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());

    $redirect = $APPLICATION->GetCurPageParam('', ['clear']);

    LocalRedirect($redirect);
}
