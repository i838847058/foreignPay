<?php

namespace app\dyrun\model;

use think\Model;
use app\dyrun\service\BaseData;

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
        unset($where['list_rows'], $where['page']);
        extract($params);
        $list_rows = $list_rows ?? 10;
        $page      = $page ?? 0;
        $self      = new self();
        // dd($country_arr, $product_type_arr, $coin_arr, $pay_way_arr, $billing_arr,123);
        $list = $self->where($where)
            ->order('id', 'desc')
            ->paginate($list_rows, false, [
                'page' => $page
            ])->each(function ($item) use ($country_arr, $product_type_arr, $coin_arr, $pay_way_arr, $billing_arr) {
                // 国家
                $item['country_ids_text'] = '';
                if ($item['country_ids'] && $country_arr) {
                    $new_country_ids = explode(',', $item['country_ids']);
                    foreach ($new_country_ids as $val) {
                        $item['country_ids_text'] .= isset($country_arr[$val])?"{$country_arr[$val]},":'';
                    }
                }
                // 支持产品类型
                $item['product_type_ids_text'] = '';
                if ($item['product_type_ids'] && $product_type_arr) {
                    $new_country_ids = explode(',', $item['product_type_ids']);
                    foreach ($new_country_ids as $val) {
                        $item['product_type_ids_text'] .= isset($product_type_arr[$val])?"{$product_type_arr[$val]},":'';
                    }
                }
                // 货币-代收
                $item['coin_ids_text'] = '';
                if ($item['coin_ids'] && $coin_arr) {
                    $new_coin_ids = explode(',', $item['coin_ids']);
                    foreach ($new_coin_ids as $val) {
                        $item['coin_ids_text'] .= isset($coin_arr[$val])?"{$coin_arr[$val]},":'';
                    }
                }
                // 支付方式-代收
                $item['pay_way_ids_text'] = '';
                if ($item['pay_way_ids'] && $coin_arr) {
                    $new_coin_ids = explode(',', $item['pay_way_ids']);
                    foreach ($new_coin_ids as $val) {
                        $item['pay_way_ids_text'] .= isset($pay_way_arr[$val])?"{$pay_way_arr[$val]},":'';
                    }
                }
                // 结算周期
                $item['billing_ids_text'] = '';
                if ($item['billing_ids'] && $coin_arr) {
                    $new_coin_ids = explode(',', $item['billing_ids']);
                    foreach ($new_coin_ids as $val) {
                        $item['billing_ids_text'] .= isset($billing_arr[$val])?"{$billing_arr[$val]},":'';
                    }
                }
                // 支付方式-代付
                $item['out_pay_way_ids_text'] = '';
                if ($item['out_pay_way_ids'] && $coin_arr) {
                    $new_coin_ids = explode(',', $item['out_pay_way_ids']);
                    foreach ($new_coin_ids as $val) {
                        $item['out_pay_way_ids_text'] .= isset($pay_way_arr[$val])?"{$pay_way_arr[$val]},":'';
                    }
                }
                return $item;
            });
        return $list;
    }

}
