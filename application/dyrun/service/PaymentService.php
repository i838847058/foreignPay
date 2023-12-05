<?php

namespace app\dyrun\service;

use app\common\model\Merchant;
use app\dyRun\dao\PaymentDao;
use app\dyrun\library\Payment\PayHaYuClient;
use GuzzleHttp\Exception\GuzzleException;

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
        // 写入订单数据
        if ($this->createPaymentOrder($this->mch, $params)) {
            // 请求上游接口
            $payLib = new PayHaYuClient();
            if ($payLib->paymentAdd($this->payOderNo, (string)$this->payAmount, $params['mch_name'] ?? $this->mch->getMchName(), $params['mch_tel'] ?? ('130100' . (10000 + $this->mch->id)), $params['mch_email'] ?? ((10000 + $this->mch->id) . '@foreign.pay'), $params['pay_type'] ?? PayHaYuClient::TYPE_INR)) {
                $this->status = 1; // 请求成功
            } else {
                $this->status = -2;
            }
            // 记录请求结果
            $this->updatePaymentOrder('gateway_params', $payLib->getRequestParams());
            $this->updatePaymentOrder('gateway_response', $payLib->getJsonResponse());
            // 赋值服务
            $this->result = $payLib->getJsonResponse();
            $this->response = $payLib->getClientResponse();
        }
    }

}