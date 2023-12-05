<?php

use app\common\model\Merchant;
use app\common\model\PaymentOrders;

abstract class PaymentDao
{
    protected string $payGateway;

    protected string $payOderNo;

    protected float $payAmount;

    protected string $msg;

    protected string $apiMsg;

    protected array $result = [];

    protected int $status = 0;

    protected PaymentOrders $paymentOrders;

    private const STATUS_MSG = [
        2 => '支付服务重试',
        1 => '支付服务成功',
        0 => '支付服务暂停',
        -1 => '支付服务不存在',
        -2 => '支付服务处理失败',
    ];

    /**
     * @param Merchant $merchant
     * @param array $params
     * @return bool
     */
    public function createOrUpdatePaymentOrder(Merchant $merchant, array $params): bool
    {
        if ($merchant->id ?? 0) {
            return false;
        }
        $this->paymentOrders->merchant_id = $merchant->id;
        $this->paymentOrders->order_no = $this->payOderNo;
        $this->paymentOrders->order_amount = $this->payAmount;
        $this->paymentOrders->gateway_name = $this->payGateway;
        $this->paymentOrders->gateway_params = $params;
        $this->paymentOrders->save();
        return true;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getpayGateway(): string
    {
        return $this->payGateway;
    }

    /**
     * @param string $payGateway
     */
    public function setpayGateway(string $payGateway): void
    {
        $this->payGateway = $payGateway;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return self::STATUS_MSG[$this->status];
    }

    /**
     * @return string
     */
    public function getApiMsg(): string
    {
        return $this->apiMsg;
    }

    /**
     * @return string
     */
    public function getPayOderNo(): string
    {
        return $this->payOderNo;
    }

    /**
     * @param string $payOderNo
     */
    public function setPayOderNo(string $payOderNo): void
    {
        $this->payOderNo = $payOderNo;
    }

    /**
     * @return float
     */
    public function getPayAmount(): float
    {
        return $this->payAmount;
    }

    /**
     * @param float $payAmount
     */
    public function setPayAmount(float $payAmount): void
    {
        $this->payAmount = $payAmount;
    }
}