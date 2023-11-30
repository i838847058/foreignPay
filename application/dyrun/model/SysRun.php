<?php

namespace app\dyrun\model;

use app\dyrun\service\BaseData;
use think\Model;

/**
 * 运营管理-支付配置
 */
class SysRun extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 定义附加属性
    protected $append = ['pay_success_rate', 'coin_ids_text', 'pay_way_id_text'];

    // 定义访问器-支付成功率
    public function getPaySuccessRateAttr($value, $data)
    {
        // 统计计算
        return 100;
    }

    public function getSingleDayLimitMoneyAttr($value, $data)
    {
        return (float)$data['single_day_limit_money'];
    }

    public function getSingleLimitMoneyAttr($value, $data)
    {
        return (float)$data['single_limit_money'];
    }

    public function getPayRateAttr($value, $data)
    {
        return (float)$data['pay_rate'];
    }

    public function getFeeRateInAttr($value, $data)
    {
        return (float)$data['fee_rate_in'];
    }

    public function getCoinsInAttr($value, $data)
    {
        $data['coins_in'] = json_decode($data['coins_in'], true);
        return array_map('intval', $data['coins_in']);
    }

    // 币种-中文
    public function getCoinIdsTextAttr($value, $data)
    {
        if ($data['coins_in']) {
            $data['coins_in'] = json_decode($data['coins_in'], true);
            $data['coins_in'] = array_map('intval', $data['coins_in']);
            list($coin_arr, $pay_way_arr) = $this->getBaseOption();
            $arr = is_array($data['coins_in']) ? $data['coins_in'] : explode(',', $data['coins_in']);
            foreach ($arr as $v) {
                $coin_arr_cn[] = $coin_arr[$v];
                return implode(',', $coin_arr_cn);
            }
        }
        return '';
    }

    // 支付方式-中文
    public function getPayWayIdTextAttr($value, $data)
    {
        if ($data['pay_way_id']) {
            list($coin_arr, $pay_way_arr) = $this->getBaseOption();
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
        return [$coin_arr, $pay_way_arr];
    }

}
