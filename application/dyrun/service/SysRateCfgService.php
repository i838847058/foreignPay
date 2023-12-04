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
        $rows              = $rows ?? 10;
        $page              = $page ?? 0;
        $SysChannelService = new \app\dyrun\service\SysChannelService();
        list($product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr) = $SysChannelService->getBaseOption();
        $list = $this->sysRateCfgModel
            ->order('id', 'desc')
            ->paginate($rows, false, [
                'page' => $page
            ])
            ->each(function ($item) use ($coin_arr) {
                // 货币
                $item['coin_id_text'] = $coin_arr[$item['coin_id']] ?? '';
                return $item;
            });;
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
        return $this->sysRateCfgModel->allowField(true)->save($params, [
            'id' => $params['id']
        ]);
    }


}
