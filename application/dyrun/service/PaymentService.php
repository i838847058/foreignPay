<?php

namespace app\dyrun\service;

use app\common\model\Merchant;
use app\dyrun\library\Payment\PayHaYuClient;
use GuzzleHttp\Exception\GuzzleException;
use PaymentDao;

/**
 * PaymentService
 */
class PaymentService extends PaymentDao
{
    const PAY_NAME_PAYHAYU = 'PayHaYu';

    protected Merchant $mch; // TODO 必须传入商户模型

    public function __construct(Merchant $merchant)
    {
        $this->mch = $merchant;
    }

    /**
     * 统一代收 上游服务
     * @param string $payName
     * @param string $oderNo
     * @param float $amount
     * @param array $option
     * @return bool
     */
    public function createOrderIn(string $payName, string $oderNo, float $amount, array $option = []): bool
    {
        $this->payName = $payName;
        $this->payOption = $option;
        try {
            switch ($payName) {
                case self::PAY_NAME_PAYHAYU:
                    $this->payForPayHaYu($option);
                    break;
                default:
                    $this->status = -1; // 支付配置错误
                    return false;
            }
            return true;
        } catch (GuzzleException $e) {
            $this->status = -2; // 接口处理失败
            $this->apiMsg = $e->getMessage(); // 异常信息
            return false;
        }
    }

    /**
     * @param array $option
     * @return void
     * @throws GuzzleException
     */
    private function payForPayHaYu(array $option)
    {
        // TODO 写接口订单

        // TODO 请求第三方
        $payLib = new PayHaYuClient();
        $payLib->paymentAdd('', '', '', '', '', '', '');
        $payLib->jsonRaw;
        $this->result = [];
//        dd($payLib->getJsonResponse());
    }

}