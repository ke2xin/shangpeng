<?php
$orderInfo = array();
$orderInfo[0] = '<C>顾客：123456</C><BR>';
$orderInfo[1] = '名称　　　　　 单价  数量 金额<BR>';
$orderInfo[2] = '--------------------------------<BR><CUT>';
$orderInfo[4] = '饭　　　　　 　10.0   10  100.0<BR><CUT>';
$orderInfo[5] = '炒饭　　　　　 10.0   10  100.0<BR><CUT>';
$orderInfo[6] = '鸡蛋炒饭　　　 10.0   10  100.0<BR><CUT>';
$orderInfo[7] = '--------------------------------<BR><CUT>';
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
echo $order;