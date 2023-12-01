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
        $where = [];
        extract($params);
        if (!empty($merchant_id)) {
            $where['r.merchant_id'] = $merchant_id;
        }
        if (!empty($sys_channel_id)) {
            $where['r.sys_channel_id '] = $sys_channel_id;
        }
        // 商户信息表的检索
        if (!empty($product_type_id)) {
            $where['m.product_type_id'] = $product_type_id;
        }
        if (!empty($product_name)) {
            $where['m.product_name'] = ['like', "{$product_name}%"];
        }
        $field             = ['r.*', 'm.merchant_name', 'c.channel_name', 'c.channel_num', 'c.pay_rate', 'm.fee_rate_in', 'm.coins_in', 'm.pay_way_id', 'm.product_type_id', 'm.product_name'];
        $rows              = $rows ?? 10;
        $page              = $page ?? 0;
        $SysChannelService = new \app\dyrun\service\SysChannelService();
        list($product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr) = $SysChannelService->getBaseOption();
        $list = $this->sysRunModel
            ->field($field)
            ->where($where)
            ->order('r.id', 'desc')
            ->alias('r')
            ->join('merchant m', 'm.id = r.merchant_id')
            ->join('sys_channel c', 'c.id = r.sys_channel_id')
            ->paginate($rows, false, [
                'page' => $page
            ])
            ->each(function ($item) use ($country_arr, $coin_arr, $product_type_arr, $pay_way_arr, $billing_arr) {
                // 货币-代收
                $coins_in              = is_array($item['coins_in']) ? $item['coins_in'] : json_decode($item['coins_in'], true);
                $item['coins_in_text'] = implode(',', array_intersect_key($coin_arr, array_flip($coins_in)));
                // 支付方式-代收
                $item['pay_way_id_text'] = $pay_way_arr[$item['pay_way_id']] ?? '';
                // 支持产品类型
                $item['product_type_id_text'] = $product_type_arr[$item['product_type_id']] ?? '';
                return $item;
            });
        return $list;
    }

    // 新增
    public function addSysRun($params)
    {
        return $this->sysRunModel->allowField(true)->save($params);
    }

    // 编辑
    public function editSysRun($params)
    {
        return $this->sysRunModel->allowField(true)->save($params, [
            'id' => $params['id']
        ]);
    }


}
