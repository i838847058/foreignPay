<?php

namespace app\dyrun\service;

use app\dyrun\model\SysRateCfg as SysRateCfgModel;

/**
 * 汇率
 */
class SysRateCfgService
{

    private $sysRateCfgModel;


    public function __construct()
    {
        $this->sysRateCfgModel = new SysRateCfgModel();
    }

    // 列表
    public function getSysRate($params)
    {
        $rows = $rows ?? 10;
        $page = $page ?? 0;
        $list = $this->sysRateCfgModel
            ->order('id', 'desc')
            ->paginate($rows, false, [
                'page' => $page
            ]);
        return $list;
    }

    // 新增
    public function addSysRate($params)
    {
        return $this->sysRateCfgModel->allowField(true)->save($params, false);
    }

    // 编辑
    public function editSysRate($params)
    {
        $id = (int)$params['id'];
        unset($params['id']);
        return $this->sysRateCfgModel->allowField(true)->save($params, [
            'id' => $id
        ]);
    }


}
