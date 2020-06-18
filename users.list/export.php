<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\UserTable;

$userList = UserTable::getList(
    array(
        'order' => array('ID' => 'ASC'),
        'select' => array('ID', 'NAME'),
        'filter' => array()
    )
)->fetchAll();
$now = gmdate("D, d M Y H:i:s");
header("Expires: Tue, 03 Jul 20017 12:00:00 GMT");
header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
header("Last-Modified: " . $now . " GMT");

header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Transfer-Encoding: binary");

if($_REQUEST["mode"] == "csv"){

    header("Content-type: text/csv");
    header("Content-Disposition: attachment;filename=export.csv");

    $df = fopen("php://output", 'w');
    foreach ($userList as $row) {
        fputcsv($df, [
            $row['ID'],
            $row['NAME'],
        ]);
    }

    fclose($df);
}elseif($_REQUEST["mode"] == "xml"){

    header("Content-type: text/xml");
    header("Content-Disposition: attachment;filename=export.xml");

    $df = fopen("php://output", 'w');
    fwrite($df, '<users_list>'.PHP_EOL);
    foreach ($userList as $row) {
        $strUser = '<id>'.$row['ID'].'</id><name>'.$row['NAME'].'</name>'.PHP_EOL;
        fwrite($df, $strUser);
    }
    fwrite($df, '</users_list>');

    fclose($df);
}

