<?php

namespace app\common\model;

use think\Model;

/**
 * 基础数据-国家模型
 */
class SysCountry extends Model
{


    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 追加属性
    protected $append = [
    ];


    /**
     * 获取国家列表
     * @param $params
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * @author hsy 2023-11-23
     */
    public static function getSysCountryList()
    {
        $self = new self();
        $list = $self->where('')->column('id,name');
        return $list;
    }

}
