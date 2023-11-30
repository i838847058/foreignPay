<?php

namespace app\dyrun\service;

use app\dyrun\model\SysRun as SysRunModel;

/**
 * 运营管理-支付配置
 */
class SysRunService
{

    private $sysRunModel;


    public function __construct()
    {
        $this->sysRunModel = new SysRunModel();
    }

    // 列表
    public function getSysRun($params)
    {
        $where          = [];
        $merchant_where = [];
        extract($params);
        if (isset($merchant_id)) {
            $where['r.merchant_id'] = $merchant_id;
        }
        if (isset($sys_channel_id)) {
            $where['r.sys_channel_id '] = $sys_channel_id;
        }
        // 商户信息表的检索
        if (isset($product_type_id)) {
            $where['m.product_type_id'] = $product_type_id;
        }
        if (isset($product_name)) {
            $where['m.product_name'] = ['like', "{$product_name}%"];
        }
        $list_rows = $list_rows ?? 10;
        $page      = $page ?? 0;
        $list      = $this->sysRunModel
            ->where($where)
            ->order('r.id', 'desc')
            ->alias('r')
            ->join('merchant m', 'm.id = r.merchant_id')
            ->join('sys_channel c', 'c.id = r.sys_channel_id')
            ->paginate($list_rows, false, [
                'page' => $page
            ]);
        return $list;
    }

    // 新增
    public function addSysRun($params)
    {
        return $this->sysRunModel->insert($params);
    }

    // 编辑
    public function editSysRun($params)
    {
        return $this->sysRunModel->allowField(true)->save($params, [
            'id' => $params['id']
        ]);
    }


}