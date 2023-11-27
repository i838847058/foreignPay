<?php

namespace app\dyrun\validate;

use think\Validate;

class SysChannel extends Validate
{

    protected $rule = [
        'id'               => 'number',
        'channel_name'     => 'require|max:255',
        'channel_num'      => 'require|max:100|unique:sys_channel',
        'country_ids'      => 'require|array',
        'product_type_ids' => 'require|array',
        'coin_ids'         => 'require|array',
        'pay_way_ids'      => 'require|array',
        'billing_ids'      => 'require|array',
        'out_pay_way_ids'  => 'require|array',
        'pay_rate'         => 'require|float|between:0,99.99',
        'status'           => 'require|in:0,1',
        'margin_balance'   => 'require|float',
        'balance'          => 'require|float',
    ];

    protected $scene = [
        'add'          => ['id', 'channel_name', 'channel_num', 'country_ids', 'product_type_ids', 'coin_ids', 'pay_way_ids', 'billing_ids', 'out_pay_way_ids', 'pay_rate', 'status', 'margin_balance', 'balance'],
        'edit'         => ['id' => 'require', 'channel_name', 'channel_num', 'country_ids', 'product_type_ids', 'coin_ids', 'pay_way_ids', 'billing_ids', 'out_pay_way_ids', 'pay_rate', 'status', 'margin_balance', 'balance'],
        'updateStatus' => ['id' => 'require', 'status'],
    ];

    protected $message = [
        'id'          => '请选择一条操作记录',
        'channel_num' => '渠道号已存在',
    ];

}
