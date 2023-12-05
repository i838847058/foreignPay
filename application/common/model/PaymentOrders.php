<?php

namespace app\common\model;

use think\Model;

class PaymentOrders extends Model
{
    const orderStatus = [
        -2 => '取消订单',
        -1 => '失败订单',
        0 => '等待订单',
        1 => '成功订单',
        // 其他状态...
    ];

    const gatewayStatus = [
        0 => '请求失败',
        1 => '请求成功'
    ];

    // 定义字段类型
    protected $type = [
        'order_amount' => 'float',
        'gateway_params' => 'json',
        'gateway_response' => 'json',
        'callback_response' => 'json',
        'callback_amount' => 'float',
        'callback_time' => 'datetime',
    ];

    // 定义自动写入时间戳字段
//    protected $autoWriteTimestamp = true;

    // 定义日期时间字段格式
    protected $dateFormat = 'Y-m-d H:i:s';

    // 定义字段名对应的属性名
    protected $field = [
        'merchant_id' => 'merchant_id',
        'order_no' => 'order_no',
        'order_amount' => 'order_amount',
        'order_status' => 'order_status',
        'gateway_name' => 'gateway_name',
        'gateway_params' => 'gateway_params',
        'gateway_response' => 'gateway_response',
        'gateway_status' => 'gateway_status',
        'callback_response' => 'callback_response',
        'callback_amount' => 'callback_amount',
        'callback_time' => 'callback_time'
    ];

    // 定义字段验证规则
    protected $validate = [
        'order_no' => 'unique:fp_payment_orders',
    ];

    // 定义获取器
//    public function getOrderStatusAttr($value): string
//    {
//        // 自定义获取器，处理订单状态
//        $status = self::orderStatus;
//        return $status[$value] ?? '未知状态';
//    }

}
