<?require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>

<?if ((CModule::IncludeModule('search')) && (CModule::IncludeModule('iblock'))) {
    $q = $_REQUEST['q'];
    $obSearch = new CSearch;
    $obSearch->Search(array("QUERY" => $q, "SITE_ID" => 's1', "MODULE_ID" => 'iblock', "CHECK_DATES" => 'Y', "PARAM1" => "catalog", "PARAM2" => "1"));
    $result = array();
    while ($res = $obSearch->GetNext()) {
        $id = $res['ITEM_ID'];
        if (strripos($id, 'S') !== false) { // Если это раздел
            $result_item['TITLE'] = $res['TITLE'];
            $result_item['URL'] = $res['URL'];
            $result_item['BODY_FORMATED'] = $res['TITLE_FORMATED'];
            $result[] = $result_item;
        } else {
            $result_item['TITLE'] = $res['TITLE'];
            $result_item['URL'] = $res['URL'];
            $result_item['BODY_FORMATED'] = $res['BODY_FORMATED'];
            $result[] = $result_item;
        }
    }

    echo json_encode($result);
}
?>
