<?php

namespace app\dyrun\validate;

use think\Validate;

class MerchantWithdrawU extends Validate
{

    protected $rule    = [
        'status'      => 'in:0,1',
        'out_address' => 'require|max:100',
        'out_balance' => 'require|float',
        'coin_id'     => 'require|integer',
        'rate'        => 'require|float',
        'hand_fee'    => 'require|float',
        'u_amount'    => 'require|float',
    ];
    protected $message = [
        'status.in'           => '状态值不正确',
        'out_address.require' => '代付地址不能为空',
        'out_address.max'     => '代付地址长度不能超过100个字符',
        'out_balance.require' => '代付金额不能为空',
        'out_balance.float'   => '代付金额格式不正确',
        'coin_id.require'     => '币种不能为空',
        'coin_id.integer'     => '币种必须为整数',
        'rate.require'        => '提U汇率不能为空',
        'rate.float'          => '提U汇率格式不正确',
        'hand_fee.require'    => '手续费不能为空',
        'hand_fee.float'      => '手续费格式不正确',
        'u_amount.require'    => '提U个数不能为空',
        'u_amount.float'      => '提U个数格式不正确',
    ];
    protected $scene   = [
        'add'          => ['status', 'out_address', 'out_balance', 'coin_id', 'rate', 'hand_fee', 'u_amount'],
        // 'edit'         => ['id' => 'require', 'status', 'out_address', 'out_balance', 'coin_id', 'rate', 'hand_fee', 'u_amount'],
        // 'updateStatus' => ['id' => 'require', 'status'],
    ];

}
