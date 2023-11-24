<?php

namespace app\dyrun\validate;

use think\Validate;

class SysChannel extends Validate
{

    protected $rule = [
        'id'                      => 'number',
        'channel_name'            => 'require|max:255',
        'channel_short_name'      => 'require|max:255',
        'channel_num'             => 'require|max:100',
        'pay_product'             => 'require|max:255',
        'trans_currency'          => 'require|max:255',
        'country_id'              => 'require|number',
        'support_product_type_id' => 'require|number',
        'no_product'              => 'max:255',
        'pay_method'              => 'require|max:255',
        'pay_rate'                => 'require|float',
        'settlement_cycle'        => 'require|max:255',
        'status'                  => 'require|in:0,1',
        'margin_balance'          => 'require|float',
    ];

    protected $scene = [
        'add'          => ['channel_name', 'channel_short_name', 'channel_num', 'pay_product', 'trans_currency', 'country_id', 'support_product_type_id', 'no_product', 'pay_method', 'pay_rate', 'settlement_cycle', 'status', 'margin_balance'],
        'edit'         => ['id' => 'require', 'channel_name', 'channel_short_name', 'channel_num', 'pay_product', 'trans_currency', 'country_id', 'support_product_type_id', 'no_product', 'pay_method', 'pay_rate', 'settlement_cycle', 'status', 'margin_balance'],
        'updateStatus' => ['id' => 'require', 'status'],
    ];

    protected $message = [
        'id' => '请选择一条操作记录',
    ];

}
