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
        $where = $params;
        unset($where['list_rows'], $where['page']);
        extract($params);
        $list_rows = $list_rows ?? 10;
        $page      = $page ?? 0;
        // 查询fp_sys_run列表并关联fp_merchant和fp_sys_channel的数据
        $list = $this->sysRunModel
            ->where($where)
            ->order('id', 'desc')
            ->with('merchants,channels')
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
