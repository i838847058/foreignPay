<?php

namespace app\dyrun\service;

use app\dyrun\model\SysChannel;
use app\dyrun\service\BaseData;
use think\exception\DbException;

/**
 * 第三方银行渠道模型
 */
class SysChannelService
{

    /**
     * 获取渠道列表
     * @param $params
     * @return \think\Paginator
     * @throws DbException|\think\Exception
     * @author hsy 2023-11-23
     */
    public function getSysChannelList($params)
    {
        $service = new BaseData();
        // 国家
        $country_arr  = [];
        $country_list = $service->getCountrys();
        foreach ($country_list as $v) {
            $country_arr[$v['id']] = $v['name'];
        }
        $base_list = $service->getConfigValue();
        // 产品类型
        $product_type_arr = [];
        foreach ($base_list['product_type'] as $v) {
            $product_type_arr[$v['id']] = $v['value'];
        }
        // 货币
        $coin_arr = [];
        foreach ($base_list['coin'] as $v) {
            $coin_arr[$v['id']] = $v['value'];
        }
        // 支付方式
        $pay_way_arr = [];
        foreach ($base_list['pay_way'] as $v) {
            $pay_way_arr[$v['id']] = $v['value'];
        }
        // 结算周期
        $billing_arr = [];
        foreach ($base_list['billing'] as $v) {
            $billing_arr[$v['id']] = $v['value'];
        }
        $where = $params;
        unset($where['rows'], $where['page']);
        extract($params);
        $rows = $rows ?? 10;
        $page      = $page ?? 0;
        $list      = SysChannel::where($where)
            ->order('id', 'desc')
            ->paginate($rows, false, [
                'page' => $page
            ])->each(function ($item) use ($country_arr, $coin_arr, $product_type_arr, $pay_way_arr, $billing_arr) {
                // 国家
                $item['country_ids_text'] = '';
                if ($item['country_ids'] && $country_arr) {
                    $new_country_ids = explode(',', $item['country_ids']);
                    foreach ($new_country_ids as $val) {
                        $item['country_ids_text'] .= isset($country_arr[$val]) ? "{$country_arr[$val]}," : '';
                    }
                    $item['country_ids'] = array_map('intval', $new_country_ids);
                }
                // 货币-代收
                $item['coin_ids_text'] = '';
                if ($item['coin_ids'] && $coin_arr) {
                    $new_coin_ids = explode(',', $item['coin_ids']);
                    foreach ($new_coin_ids as $val) {
                        $item['coin_ids_text'] .= isset($coin_arr[$val]) ? "{$coin_arr[$val]}," : '';
                    }
                    $item['coin_ids'] = array_map('intval', $new_coin_ids);
                }
                // 支持产品类型
                $item['product_type_id_text'] = '';
                if ($item['product_type_id'] && $product_type_arr) {
                    $item['product_type_id_text'] = $product_type_arr[$item['product_type_id']] ?? '';
                }

                // 支付方式-代收
                $item['pay_way_id_text'] = '';
                if ($item['pay_way_id'] && $pay_way_arr) {
                    $item['pay_way_id_text'] = $pay_way_arr[$item['pay_way_id']] ?? '';
                }
                // 结算周期
                $item['billing_id_text'] = '';
                if ($item['billing_id'] && $billing_arr) {
                    $item['billing_id_text'] = $billing_arr[$item['billing_id']] ?? '';
                }
                return $item;
            });
        return $list;
    }

    // 根据渠道名称-获取渠道信息
    public function getChannelByChannelName($channel_name = '')
    {
        $where = [];
        if ($channel_name) {
            $where['channel_name'] = ['like', "{$channel_name}%"];
        }
        $datas = SysChannel::where($where)->select();
        return $datas;
    }

}
