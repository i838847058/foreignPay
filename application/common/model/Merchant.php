<?php

namespace app\common\model;


use app\dyrun\service\BaseData;

class Merchant extends BaseModel
{
    const UPDATE_FIELD = [
        'user_id',
        'countrys',
        'agent_user_id',
        'agent_rate_in',
        'agent_rate_out',
        'product_type_id',
        'product_name',
        'pay_way_id',
        'coins_in',
        'fee_rate_in',
        'coins_out',
        'fee_rate_out',
        'is_usdt_out',
        'deposit_rate',
        'status'
    ];

    const VALIDATE = [
        'user_id' => 'require|chsDash',
        'merchant_name' => 'require|chsDash|unique:merchant',
        'merchant_no' => 'require|number|unique:merchant',
        'countrys' => 'require|array',
        'agent_mch_id' => 'number',
        'agent_rate_in' => 'float',
        'agent_rate_out' => 'float',
        'product_type_id' => 'number',
        'product_name' => 'chsDash',
        'pay_way_id' => 'number',
        'coins_in' => 'array',
        'fee_rate_in' => 'float',
        'coins_out' => 'array',
        'fee_rate_out' => 'float',
        'is_usdt_out' => 'number',
        'deposit_rate' => 'float',
        'status' => 'in:0,1'
    ];

    /**
     * @var string[]
     */
    protected $field = ['user_id', 'merchant_name', 'countrys', 'merchant_no', 'agent_user_id', 'agent_id', 'check_user_id', 'check_time', 'check_state', 'check_reason', 'agent_rate_in', 'agent_rate_out', 'product_type_id', 'product_name', 'pay_way_id', 'coins_in', 'fee_rate_in', 'coins_out', 'fee_rate_out', 'is_usdt_out', 'deposit_rate', 'api_key', 'status'];

    protected $append = ['pay_way_id_text', 'product_type_id_text', 'coins_in_text'];


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
        $this->convertToFloat($value);
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
        $this->convertToFloat($value);
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
     * @return false|string
     */
//    public function getCheckTimeAttr($value)
//    {
//        return $value == 0 ? 0 : date('Y-m-d H:i:s', $value);
//    }

    /**
     * @param $value
     * @return string
     */
    public function setCoinsOutAttr($value): string
    {
        $this->convertToFloat($value);
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return '[]';
    }


    // 币种-中文
    public function getCoinsInTextAttr($value, $data)
    {
        if ($data['coins_in']) {
            $data['coins_in'] = json_decode($data['coins_in'], true);
            $data['coins_in'] = array_map('intval', $data['coins_in']);
            list($coin_arr, $pay_way_arr,$product_type_arr) = $this->getBaseOption();
            $arr = is_array($data['coins_in']) ? $data['coins_in'] : explode(',', $data['coins_in']);
            foreach ($arr as $v) {
                $coin_arr_cn[] = $coin_arr[$v];
                return implode(',', $coin_arr_cn);
            }
        }
        return '';
    }

    // 支付产品-中文-代收-代付
    public function getProductTypeIdTextAttr($value, $data)
    {
        if ($data['product_type_id']) {
            list($coin_arr, $pay_way_arr, $product_type_arr) = $this->getBaseOption();
            return $product_type_arr[$data['product_type_id']] ?? '';
        }
        return '';
    }

    // 支付方式-中文
    public function getPayWayIdTextAttr($value, $data)
    {
        if ($data['pay_way_id']) {
            list($coin_arr, $pay_way_arr,$product_type_arr) = $this->getBaseOption();
            return $pay_way_arr[$data['pay_way_id']];
        }
        return '';
    }

    protected function getBaseOption()
    {
        $base_list = (new BaseData())->getConfigValue();
        // 货币
        $coin_arr = [];
        foreach ($base_list['coin'] as $v) {
            $coin_arr[$v['id']] = $v['value'];
        }
        // 支付方式
        $pay_way_arr = [];
        foreach ($base_list['pay_way'] as $v) {
            $pay_way_arr[$v['id']] = $v['value'];
        }
        // 产品类型
        $product_type_arr = [];
        foreach ($base_list['product_type'] as $v) {
            $product_type_arr[$v['id']] = $v['value'];
        }
        return [$coin_arr, $pay_way_arr,$product_type_arr];
    }
}
