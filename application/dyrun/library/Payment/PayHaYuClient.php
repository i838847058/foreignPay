<?php

namespace app\dyrun\library\Payment;

use app\dyrun\library\HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class PayHaYuClient
{
    use HttpClient;

    /**
     * @var string
     */
    private $merchantNo = '6559218556';

    /**
     * @var string
     */
    private $PAY_KEY_IN = 'dVptATLGMtIiDaZ2eGvpkw4L5prRXy0I';

    /**
     * @var string
     */
    private $PAY_KEY_OUT = 'laKZBIFGgQMTe0z4WagAoZmpGltqpLkY';

    /**
     * @param string|null $host
     */
    public function __construct(string $host = null)
    {
        $this->setHttpClient($host ?: 'https://www.payhayu.com', 5);
    }

    /**
     * @param string $merTradeNo
     * @param string $amount
     * @param string $name
     * @param string $tel
     * @param string $email
     * @param string|null $callbackUrl
     * @param string|null $type
     * @param string|null $extra
     * @return bool
     * @throws GuzzleException
     */
    public function paymentAdd(string $merTradeNo, string $amount, string $name, string $tel, string $email, string $callbackUrl = null, string $type = null, string $extra = null): bool
    {
        $this->jsonRaw['merTradeNo'] = $merTradeNo;
        $this->jsonRaw['amount'] = $amount;
        $this->jsonRaw['name'] = $name;
        $this->jsonRaw['tel'] = $tel;
        $this->jsonRaw['email'] = $email;
        if (!empty($callbackUrl)) {
            $this->jsonRaw['callbackUrl'] = $callbackUrl;
        }
        if (!empty($type)) {
            $this->jsonRaw['type'] = $type;
        }
        if (!empty($extra)) {
            $this->jsonRaw['extra'] = $extra;
        }
        // TODO 创建支付订单
        return $this->requestHandle('/ext_api/v1/payment/add');
    }

    /**
     * @param string $merTradeNo
     * @return bool
     * @throws GuzzleException
     */
    public function paymentQuery(string $merTradeNo): bool
    {
        $this->jsonRaw['merTradeNo'] = $merTradeNo;
        // TODO 创建支付订单
        return $this->requestHandle('/ext_api/v1/payment/query');
    }

    /**
     * @param string $uri
     * @return bool
     * @throws GuzzleException
     */
    private function requestHandle(string $uri): bool
    {
        $this->jsonRaw['merchantNo'] = $this->merchantNo;
        $this->jsonRaw['sign'] = $this->getSignKey($this->jsonRaw);
        return $this->requestClient($uri);
    }

    /**
     * @param array $data
     * @return string
     */
    private function getSignKey(array $data): string
    {// 对请求参数进行 ASCII 排序
        ksort($data);
        // 拼接加密内容
        $content = http_build_query($data) . "&signKey=" . $this->PAY_KEY_IN;
        // MD5 加密
        return strtoupper(md5($content));
    }


}