<?php

namespace app\dyrun\service;

use PaymentDao;

/**
 * PaymentService
 * @property int $orderId
 */
class PaymentService extends PaymentDao
{
    /**
     * @var int
     */
    private $orderId;

    public function __construct($payWay, $payName, $payType, $orderId = 0)
    {
        $this->payWay = $payWay;
        $this->payName = $payName;
        $this->payType = $payType;
        $this->orderId = $orderId;
    }

    public function createOrder(float $amount, string $out_trade_no, array $option = [])
    {

    }

    /**
     * @return int|mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int|mixed $orderId
     */
    public function setOrderId($orderId): void
    {
        $this->orderId = $orderId;
    }
}