<?php

namespace app\dyrun\service;

use app\common\model\Merchant;
use PaymentDao;

/**
 * PaymentService
 * @property int $orderId
 * @property Merchant $Merchant
 */
class PaymentService extends PaymentDao
{
    const PAY_NAME_PAYHAYU = 'PayHaYu';

    public function __construct(Merchant $merchant)
    {
        $this->Merchant = $merchant;
    }

    public function createOrder(string $payName, float $amount, array $option = [])
    {
        $this->payName = $payName;
        $this->payOption = $option;
        switch ($payName) {
            case self::PAY_NAME_PAYHAYU:
                break;
            default:
                return $this;
        }
    }

}