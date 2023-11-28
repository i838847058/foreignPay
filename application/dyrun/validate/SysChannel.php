<?php

namespace app\dyrun\validate;

use think\Validate;

class SysChannel extends Validate
{

    protected $rule = [
        'id'              => 'number',
        'channel_name'    => 'require|max:255|unique:sys_channel',
        'channel_num'     => 'require|max:100',
        'country_ids'     => 'require|array',
        'coin_ids'        => 'require|array',
        'product_type_id' => 'require|number',
        'pay_way_id'      => 'require|number',
        'billing_id'      => 'require|number',
        'is_u'            => 'require|in:0,1',
        'pay_rate'        => 'require|float|between:0,99.99',
        'status'          => 'require|in:0,1',
        'margin_balance'  => 'require|float',
        'balance'         => 'require|float',
    ];

    protected $scene = [
        'add'          => ['channel_name', 'channel_num', 'country_ids', 'coin_ids', 'product_type_id', 'pay_way_id', 'billing_id', 'is_u', 'pay_rate', 'status', 'margin_balance', 'balance'],
        'edit'         => ['id' => 'require', 'channel_name', 'channel_num', 'country_ids', 'coin_ids', 'product_type_id', 'pay_way_id', 'billing_id', 'is_u', 'pay_rate', 'status', 'margin_balance', 'balance'],
        'updateStatus' => ['id' => 'require', 'status'],
    ];

    protected $message = [
        'id'           => '请选择一条操作记录',
        'channel_name' => '渠道名称已存在',
    ];

}
