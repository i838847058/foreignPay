<?php

namespace app\dyrun\model;

use think\Model;
use app\dyrun\service\BaseData;

/**
 * 第三方银行渠道模型
 */
class SysChannel extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 定义附加属性
    protected $append = ['coin_ids_pay_text', 'pay_way_id_pay_text'];

    // 币种-中文
    public function getCoinIdsPayTextAttr($value, $data)
    {
        if ($data['coin_ids']) {
            list($coin_arr, $pay_way_arr) = $this->getBaseOption();
            $arr = is_array($data['coin_ids']) ? $data['coin_ids'] : explode(',', $data['coin_ids']);
            foreach ($arr as $v) {
                $coin_arr_cn[] = $coin_arr[$v];
                return implode(',', $coin_arr_cn);
            }
        }
        return '';
    }

    // 支付方式-中文
    public function getPayWayIdPayTextAttr($value, $data)
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
