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
    protected $append = ['pay_success_rate'];

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

}
