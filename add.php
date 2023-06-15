<?php
require_once  'src/Api.php';
require_once  'src/Exception.php';

use Shangpeng\Printer\Api;
use Shangpeng\Printer\Exception;

$appid = 'sp641145acae689';
$appsecret = '070072592a4ff253f14288bf5e86a917';
$api = new Api($appid, $appsecret);

// 添加打印机
try {
    $result = $api->addPrinter('1925506479', 'ahrmqumv', '用朋1号打印机');
    // 添加成功
    var_dump($result);
} catch(Exception $e) {
    echo '失败了';
    // 添加失败
    var_dump($e);
}
