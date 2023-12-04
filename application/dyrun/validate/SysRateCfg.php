<?php

namespace app\dyrun\validate;

use think\Validate;

class SysRateCfg extends Validate
{

    protected $rule = [
        'id'      => 'number',
        'coin_id' => 'require|number|unique:sys_rate_cfg',
        'rate'    => 'require|float',
        'status'  => 'in:0,1',
    ];

    protected $scene = [
        'add'          => ['coin_id', 'rate', 'status'],
        'edit'         => ['id' => 'require', 'coin_id', 'rate', 'status'],
        'updateStatus' => ['id' => 'require', 'status'],
    ];

    protected $message = [
        'id'           => '请选择一条操作记录',
    ];

}
