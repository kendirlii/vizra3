<?php


if ($_GET["act"] == "payBill") {
    $Order->payBill($_GET["billID"]);
    iredirect("order_details", $Order->orderID);

} elseif ($_GET['act'] == 'delBill') {
    OrderBill::delete($_GET['billID']);
    core::raise('Borç kaydı sistemden silindi', 'm');

} elseif ($_POST['action'] == 'sendbill') {
    OrderBill::sendbill($_POST['billID']);
    core::raise('Ödeme hatırlatma maili gönderildi', 'm', '');

} elseif ($_POST['action'] == 'delbill') {
    OrderBill::delete($_POST['billID']);
    core::raise('Borç kaydı sistemden silindi', 'm');

} elseif ($_POST['action'] == 'genbill') {
    $ret = $Order->createNextBill(0, 'unpaid');
    if ($ret) {
        core::raise('Borç kaydı oluşturuldu', 'm');
    }

}


$Order->getBills('all', $_GET['boID']);
$addons = $db->query("SELECT orderID,title FROM orders WHERE parentID = " . $Order->orderID, SQL_KEY, 'orderID');
$core->assign('addons', $addons);
