<?php
require_once __DIR__ . '/src/Api.php';
require_once __DIR__ . '/src/Exception.php';

use Shangpeng\Printer\Api;
use Shangpeng\Printer\Exception;

$appid = 'sp641145acae689';
$appsecret = '070072592a4ff253f14288bf5e86a917';
$api = new Api($appid, $appsecret);

// 获取打印机信息
try {
    $result = $api->getPrinter('1925506479');
    // 获取成功
    //var_dump($result);
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
} catch(Exception $e) {
    // 获取失败
    var_dump($e);
}
