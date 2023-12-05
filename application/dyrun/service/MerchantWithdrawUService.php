<?php

namespace app\dyrun\service;

use app\dyrun\model\MerchantWithdrawU as MerchantWithdrawUModel;
use fast\Random;
use think\Cache;

/**
 * 商户提U
 */
class MerchantWithdrawUService
{

    private $merchantWithdrawUModel;


    public function __construct()
    {
        $this->merchantWithdrawUModel = new MerchantWithdrawUModel();
    }

    // 列表
    public function getSysRate($params)
    {
        $rows              = $rows ?? 10;
        $page              = $page ?? 0;
        $SysChannelService = new \app\dyrun\service\SysChannelService();
        list($product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr) = $SysChannelService->getBaseOption();
        $list = $this->merchantWithdrawUModel
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
        // 生成唯一ID
        $redis              = Cache::store('redis')->handler();
        $params['order_no'] = $redis->incr('global_unique_id');
        return $this->merchantWithdrawUModel->allowField(true)->save($params, false);
    }

    // 编辑
    public function editSysRate($params)
    {
        return $this->merchantWithdrawUModel->allowField(true)->save($params, [
            'id' => $params['id']
        ]);
    }


}
