<?php

namespace app\dyrun\validate;

use think\Validate;

class SysRun extends Validate
{

    protected $rule    = [
        'id'                     => 'number',
        'merchant_id'            => 'require|integer',
        'sys_channel_id'         => 'require|integer',
        'status'                 => 'require|in:0,1',
        'weigh'                  => 'require|integer',
        'single_day_limit_money' => 'require|float',
        'single_limit_money'     => 'require|float',
    ];
    protected $message = [
        'id'                             => '请选择一条操作记录',
        'merchant_id.require'            => '商户信息表ID不能为空',
        'merchant_id.integer'            => '商户信息表ID必须为整数',
        'sys_channel_id.require'         => '第三方支付渠道信息表ID不能为空',
        'sys_channel_id.integer'         => '第三方支付渠道信息表ID必须为整数',
        'status.require'                 => '状态不能为空',
        'status.in'                      => '状态值不正确',
        'weigh.require'                  => '权重不能为空',
        'weigh.integer'                  => '权重必须为整数',
        'single_day_limit_money.require' => '单日限额不能为空',
        'single_day_limit_money.float'   => '单日限额必须为浮点数',
        'single_limit_money.require'     => '单笔限额不能为空',
        'single_limit_money.float'       => '单笔限额必须为浮点数',
    ];
    protected $scene   = [
        'add'          => ['merchant_id', 'sys_channel_id', 'status', 'weigh', 'single_day_limit_money', 'single_limit_money'],
        'edit'         => ['id' => 'require', 'merchant_id', 'sys_channel_id', 'status', 'weigh', 'single_day_limit_money', 'single_limit_money'],
        'updateStatus' => ['id' => 'require', 'status'],
    ];
}
