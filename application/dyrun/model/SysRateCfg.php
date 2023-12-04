<?php

namespace app\dyrun\model;

use think\Model;

/**
 * 汇率
 */
class SysRateCfg extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

}
