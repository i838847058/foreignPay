<?php

namespace app\dyrun\model;

use think\Model;
use app\common\model\Merchant;
use app\dyrun\model\SysChannel;

/**
 * 运营管理-支付配置
 */
class SysRun extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = '';
    protected $updateTime = '';
    // 定义附加属性
    protected $append = ['pay_success_rate'];

    // 定义访问器-支付成功率
    public function getPaySuccessRateAttr($value, $data)
    {
        // 统计计算
        return 100;
    }

    // belongsToMany('关联模型名','中间表名','外键名','当前模型关联键名',['模型别名定义']);
    // belongsTo('关联模型名','外键名','关联表主键名',['模型别名定义'],'join类型');
    /*
     ->with([
            'merchants' => function ($query) use ($merchant_where) {
                $query->where($merchant_where);
            },
            'channels'
        ])
    public function merchants()
    {
        return $this->belongsTo(Merchant::class,  'merchant_id', 'id');
    }

    // 定义与FpSysChannel的多对多关联
    public function channels()
    {
        return $this->belongsTo(SysChannel::class,  'sys_channel_id', 'id');
    }*/

}
