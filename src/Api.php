<?php
namespace Shangpeng\Printer;

/**
 * @method array get(string $uri, array $query = [])
 * @method array put(string $uri, array $form_params = [])
 * @method array post(string $uri, array $form_params = [])
 * @method array patch(string $uri, array $form_params = [])
 * @method array delete(string $uri, array $form_params = [])
 */
class Api
{
    /**
     * 基本请求地址
     */
    const BASE_URI = 'https://open.spyun.net/v1/';

    /**
     * 连接超时时间
     */
    const CONNECTTIMEOUT = 100;

    /**
     * 超时时间
     */
    const TIMEOUT = 400;

    /**
     * @var string
     */
    protected $appid;

    /**
     * @var $appsecret
     */
    protected $appsecret;

    /**
     * @var string
     */
    protected $message;

    /**
     * Api constructor.
     * @param string $appid
     * @param string $appsecret
     */
    public function __construct($appid, $appsecret)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }

    /**
     * 添加打印机
     * @param int $sn
     * @param string $pkey
     * @param string $name
     * @return array
     * @throws Exception
     */
    public function addPrinter($sn, $pkey, $name)
    {
        return $this->post('printer/add', $this->makeRequestParams([
            'sn' => $sn,
            'pkey' => $pkey,
            'name' => $name,
        ]));
    }

    /**
     * 删除打印机
     * @param string $sn
     * @return array
     * @throws Exception
     */
    public function deletePrinter($sn)
    {
        return $this->delete('printer/delete', $this->makeRequestParams([
            'sn' => $sn
        ]));
    }

    /**
     * 修改打印机信息
     * @param $sn
     * @param string $name
     * @return array
     */
    public function updatePrinter($sn, $name)
    {
        return $this->patch('printer/update', $this->makeRequestParams([
            'sn' => $sn,
            'name' => $name
        ]));
    }

    /**
     * 修改打印机参数
     * @param $sn
     * @param null|int $auto_cut
     * @param null|string $voice
     * @param null|string $img
     * @return array
     */
    public function updatePrinterSetting($sn, $auto_cut = null, $voice = null)
    {
        return $this->patch('printer/setting', $this->makeRequestParams([
            'sn' => $sn,
            'auto_cut' => $auto_cut,
            'voice' => $voice
        ]));
    }

    /**
     * 获取打印机信息
     * @param string $sn
     * @return array
     * @throws Exception
     */
    public function getPrinter($sn)
    {
        return $this->get('printer/info', $this->makeRequestParams([
            'sn' =>  $sn
        ]));
    }

    /**
     * 打印订单
     * @param int $sn
     * @param string $content
     * @param int $times
     * @return array
     * @throws Exception
     */
    public function prints($sn, $content, $times = 1)
    {
        return $this->post("printer/print", $this->makeRequestParams([
            'sn' => $sn,
            'content' => $content,
            'times' => $times
        ]));
    }

    /**
     * 清空待打印订单
     * @param int $sn
     * @return array
     * @throws Exception
     */
    public function deletePrints($sn)
    {
        return $this->delete("printer/cleansqs", $this->makeRequestParams([
            'sn' => $sn
        ]));
    }

    /**
     * 查询打印订单状态
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function getPrintsStatus($id)
    {
        return $this->get("printer/order/status", $this->makeRequestParams([
            'id' => $id
        ]));
    }

    /**
     * 查询打印机历史打印订单数
     * @param string $sn
     * @param string $date
     * @return array
     * @throws Exception
     */
    public function getPrintsOrders($sn, $date)
    {
        return $this->get("printer/order/number", $this->makeRequestParams([
            'sn' => $sn,
            'date' => $date
        ]));
    }

    /**
     * 创建请求参数
     * @param array $params
     * @return array
     */
    public function makeRequestParams(array $params = [])
    {
        $params['appid'] = $this->appid;
        $params['timestamp'] = time();
        $params['sign'] = $this->makeSign($params);

        return $params;
    }

    /**
     * 创建签名
     * @param array $params
     * @return string
     */
    public function makeSign(array $params)
    {
        ksort($params);
        $sign = "";
        foreach ($params as $k => $v) {
            if ($k != "sign" && $k != "appsecret" && $v !== "" && !is_array($v) && !is_null($v)) {
                $sign .= $k . "=" . $v . "&";
            }
        }
        $sign = rtrim($sign, '&');
        $sign .= "&appsecret=" . $this->appsecret;

        return strtoupper(md5($sign));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $params
     * @return array
     * @throws Exception
     */
    protected function _request($method, $uri, array $params = [])
    {
        $ch = curl_init();
        $url = self::BASE_URI . $uri;
        if ($method == 'GET' || $method == 'DELETE') {
            $url .= '?' . http_build_query($params);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECTTIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $http_error = curl_error($ch);
        $http_errno = curl_errno($ch);
        curl_close($ch);

        $response = json_decode($response, 1);
        if ($http_code != 200) {
            throw new Exception(
                isset($response['errormsg']) ? $response['errormsg'] : $http_error,
                $http_code,
                isset($response['errorcode']) ? $response['errorcode'] : $http_errno
            );
        }

        return $response;
    }

    /**
     * @param $method
     * @param $args
     * @return array
     * @throws Exception
     */
    public function __call($method, $args)
    {
        if (count($args) < 1) {
            throw new \InvalidArgumentException(
                'Magic request methods require a URI and optional options array'
            );
        }

        $method = strtoupper($method);
        $uri = $args[0];
        $params = isset($args[1]) ? $args[1] : [];

        return $this->_request($method, $uri, $params);
    }
}
