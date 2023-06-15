<?php
require_once  'src/Api.php';
require_once  'src/Exception.php';

use Shangpeng\Printer\Api;
use Shangpeng\Printer\Exception;

$appid = 'sp641145acae689';
$appsecret = '070072592a4ff253f14288bf5e86a917';
$api = new Api($appid, $appsecret);

try {
    $result = $api->deletePrinter('1925506479');
    // 删除成功
    var_dump($result);
} catch(Exception $e) {
    // 删除失败
    var_dump($e);
}
