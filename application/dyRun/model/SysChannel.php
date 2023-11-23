<?php

namespace app\dyRun\model;

use think\Model;

/**
 * 第三方银行渠道模型
 */
class SysChannel extends Model
{


    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 追加属性
    protected $append = [
        /*'type_text',
        'flag_text',*/
    ];


    /**
     * 获取渠道列表
     * @param $params
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * @author hsy 2023-11-23
     */
    public static function getSysChannelList($params)
    {
        $where = $params;
        unset($where['list_rows'], $where['page']);
        extract($params);
        $list_rows = $list_rows ?? 10;
        $page      = $page ?? 0;
        $self      = new self();
        $list      = $self->where($where)
            ->order('id', 'desc')
            ->paginate($list_rows, false, [
                'page' => $page
            ]);
        // dd($self->getLastSql(), 123);
        return $list;
    }

}
