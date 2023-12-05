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
     * @param string $payGateway
     * @param string $oderNo
     * @param float $amount
     * @param array $option
     * @return bool
     */
    public function createOrderIn(string $payGateway, string $oderNo, float $amount, array $option = []): bool
    {
        $this->payGateway = $payGateway;
        $this->payOderNo = $oderNo;
        $this->payAmount = $amount;
        try {
            switch ($payGateway) {
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
     * @param array $params
     * @return void
     * @throws GuzzleException
     */
    private function payForPayHaYu(array $params)
    {
        // TODO 写接口订单
        $this->createOrUpdatePaymentOrder($this->mch, $params);
        // TODO 请求第三方
        $payLib = new PayHaYuClient();
        $payLib->paymentAdd('', '', '', '', '', '', '');
        $this->result = $payLib->getJsonResponse();
    }

}