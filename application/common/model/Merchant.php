<?php

namespace app\common\model;

use think\Model;

class Merchant extends Model
{
    const UPDATE_FIELD = [
        'user_id',
        'countrys',
        'agent_id',
        'agent_rate_in',
        'agent_rate_out',
        'product_type_id',
        'product_name',
        'pay_way_id',
        'coins_in',
        'fee_rate_in',
        'coins_out',
        'fee_rate_out',
        'deposit_rate',
        'status'
    ];

    /**
     * @var string[]
     */
    protected $field = ['user_id', 'merchant_name', 'countrys', 'merchant_no', 'merchant_type', 'agent_id', 'check_user_id', 'check_time', 'agent_rate_in', 'agent_rate_out', 'product_type_id', 'product_name', 'pay_way_id', 'coins_in', 'fee_rate_in', 'coins_out', 'fee_rate_out', 'api_key', 'status'];

    /**
     * @param $value
     * @return array
     */
    public function getCountrysAttr($value): array
    {
        if ($json = json_decode($value, true)) {
            return $json;
        }
        return [];
    }

    /**
     * @param $value
     * @return string
     */
    public function setCountrysAttr($value): string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return '[]';
    }

    /**
     * @param $value
     * @return array
     */
    public function getCoinsInAttr($value): array
    {
        if ($json = json_decode($value, true)) {
            return $json;
        }
        return [];
    }

    public function getAgentRateInAttr($value): float
    {
        return (float)$value;
    }

    public function getAgentRateOutAttr($value): float
    {
        return (float)$value;
    }


    public function getFeeRateInAttr($value): float
    {
        return (float)$value;
    }

    public function getFeeRateOutAttr($value): float
    {
        return (float)$value;
    }

    public function getDepositRateAttr($value): float
    {
        return (float)$value;
    }

    /**
     * @param $value
     * @return string
     */
    public function setCoinsInAttr($value): string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return '[]';
    }

    /**
     * @param $value
     * @return array
     */
    public function getCoinsOutAttr($value): array
    {
        if ($json = json_decode($value, true)) {
            return $json;
        }
        return [];
    }

    /**
     * @param $value
     * @return string
     */
    public function setCoinsOutAttr($value): string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return '[]';
    }
}
