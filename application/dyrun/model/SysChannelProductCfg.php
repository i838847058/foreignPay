<?php

namespace app\dyrun\model;

use think\Model;

/**
 * 第三方渠道配置信息表
 */
class SysChannelProductCfg extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';

}
