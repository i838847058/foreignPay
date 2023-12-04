<?php

namespace app\dyrun\service;

use app\dyrun\model\SysChannel;
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
        $where = [];
        $rows  = $params['rows'] ?? 10;
        $page  = $params['page'] ?? 0;
        if (!empty($params['channel_name'])) {
            $where['channel_name'] = ['like', "{$params['channel_name']}%"];
        }
        if (!empty($params['channel_num'])) {
            $where['channel_num'] = $params['channel_num'];
        }
        if (!empty($params['created_start'])) {
            $where['created'][] = ['egt', $params['created_start']];
        }
        if (!empty($params['created_end'])) {
            $where['created'][] = ['elt', "{$params['created_end']} 23:59:59"];
        }
        list($product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr) = $this->getBaseOption();
        $list = SysChannel::where($where)
            ->order('id', 'desc')
            ->paginate($rows, false, [
                'page' => $page
            ])->each(function ($item) use ($country_arr, $coin_arr, $product_type_arr, $pay_way_arr, $billing_arr) {
                // 国家
                $item['country_ids_text'] = '';
                if ($item['country_ids'] && $country_arr) {
                    $new_country_ids          = explode(',', $item['country_ids']);
                    $item['country_ids_text'] = implode(',', array_map(function ($val) use ($country_arr) {
                        return $country_arr[$val] ?? '';
                    }, $new_country_ids));
                    $item['country_ids']      = array_map('intval', $new_country_ids);
                }
                // 货币-代收
                $item['coin_ids_text'] = '';
                if ($item['coin_ids'] && $coin_arr) {
                    $new_coin_ids          = explode(',', $item['coin_ids']);
                    $item['coin_ids_text'] = implode(',', array_map(function ($val) use ($coin_arr) {
                        return $coin_arr[$val] ?? '';
                    }, $new_coin_ids));
                    $item['coin_ids']      = array_map('intval', $new_coin_ids);
                }
                // 支持产品类型
                $item['product_type_id_text'] = $product_type_arr[$item['product_type_id']] ?? '';
                // 支付方式-代收
                $item['pay_way_id_text'] = $pay_way_arr[$item['pay_way_id']] ?? '';
                // 结算周期
                $item['billing_id_text'] = $billing_arr[$item['billing_id']] ?? '';
                return $item;
            });
        return $list;
    }

    // 根据渠道名称-获取渠道信息-小于商户费率
    public function getChannelByChannelName($fee_rate_in = '', $channel_name = '')
    {
        $where = [];
        if ($channel_name) {
            $where['channel_name'] = ['like', "{$channel_name}%"];
        }
        if ($fee_rate_in) {
            $where['pay_rate'] = ['egt', $fee_rate_in];
        }
        $datas = SysChannel::where($where)->select();
        return $datas;
    }

    public function getBaseOption()
    {
        $service = new BaseData();
        // 国家
        $country_arr = array_column($service->getCountrys(), 'name', 'id');

        $base_list = $service->getConfigValue();
        // 产品类型、货币、支付方式、结算周期
        $product_type_arr = array_column($base_list['product_type'], 'value', 'id');
        $coin_arr         = array_column($base_list['coin'], 'value', 'id');
        $pay_way_arr      = array_column($base_list['pay_way'], 'value', 'id');
        $billing_arr      = array_column($base_list['billing'], 'value', 'id');

        return [$product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr];
    }

}
