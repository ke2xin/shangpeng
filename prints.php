<?php
require_once 'src/Api.php';
require_once 'src/Exception.php';

use Shangpeng\Printer\Api;
use Shangpeng\Printer\Exception;

$appid = 'sp641145acae689';
$appsecret = '070072592a4ff253f14288bf5e86a917';
$api = new Api($appid, $appsecret);
$orderInfo = array();
$orderInfo[0] = '<C>顾客：123456</C><BR>';
$orderInfo[1] = '名称　　　　　 单价  数量 金额<BR>';
$orderInfo[2] = '--------------------------------<BR><BR><BR><BR><CUT>';
$orderInfo[4] = '<H>饭　　　　　 　10.0   10  100.0</H><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CUT>';
$orderInfo[5] = '<H>炒饭　　　　　 10.0   10  100.0</H><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CUT>';
$orderInfo[6] = '<H>鸡蛋炒饭　　　 10.0   10  100.0</H><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CUT>';
$orderInfo[7] = '--------------------------------<BR>';
$orderInfo[8] = '备注：加辣<BR>';
$orderInfo[9] = '合计：123.0元<BR>';
$orderInfo[10] = '送货地点：广州市白云区平沙南街44号力创共享B栋305<BR>';
$orderInfo[11] = '联系电话：15815649824<BR>';
$orderInfo[12] = '订餐时间：2023-08-08 08:08:08<BR>';
$orderInfo[13] = '<QRCODE>https://slpos.kosm.com.cn/ypps/ps/ckz/shangpeng/qr.png</QRCODE>';

$order = '';
foreach ($orderInfo as $k => $v) {
    $order .= $v;
}
#echo $order;
// 打印订单
try {
    $result = $api->prints('1925506479', $order, 1);
    // 打印成功
    //var_dump($result);
    echo json_encode($result);
} catch (Exception $e) {
    // 打印失败
    var_dump($e);
    echo json_encode($e);
}
