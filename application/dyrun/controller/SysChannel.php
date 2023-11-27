<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\dyrun\model\SysChannel as SysChannelModel;
use think\Loader;

/**
 * 渠道管理
 */
class SysChannel extends Api
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';


    /**
     * 获取渠道列表
     * @ApiSummary  (dyrun/sys_channel/getSysChannelList)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'channel_name': '中国银行上海支行',
    'channel_short_name': '中行',
    'channel_num': 'ZH001',
    'created': '2023-11-22 18:04:09',
    'updated': '2023-11-22 18:04:09',
    'list_rows': 10,
    'page': 1,
    })
     * @param string $channel_name  渠道名称
     * @param string $channel_short_name  渠道简称
     * @param string $channel_num  渠道号
     * @param timestamp $created  创建时间
     * @param timestamp $updated  更新时间
     * @param int $list_rows  每页条数
     * @param int $page  页数
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function getSysChannelList()
    {
        $params = $this->request->get();
        try {
            $datas = SysChannelModel::getSysChannelList($params);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

    /**
     * 新增渠道
     * @ApiSummary  (dyrun/sys_channel/addchannel)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (POST)
     * @ApiBody ({
    'channel_name': '中国银行上海支行',
    'channel_num': 'ZH002',
    'country_ids': '1,2,3',
    'product_type_ids': '33,34',
    'coin_ids': '1,2',
    'pay_way_ids': '25,26',
    'billing_ids': '29,30',
    'out_pay_way_ids': '25,26',
    'pay_rate': 10.00,
    'status': 1,
    'margin_balance': 100000.00,
    'balance': 0.00,
    })
     * @param string $channel_name  渠道名称
     * @param string $channel_num  渠道号
     * @param string $country_ids  国家多选
     * @param string $product_type_ids  支持产品类型
     * @param string $coin_ids  代收货币
     * @param string $pay_way_ids  代收支付方式
     * @param string $billing_ids  结算周期ID
     * @param string $out_pay_way_ids  代付支付方式
     * @param decimal $pay_rate  通道费率
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param decimal $margin_balance  保证金
     * @param decimal $balance  余额
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function addChannel()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysChannel');
        if (!$validate->scene('add')->check($params)) {
            $this->error($validate->getError());

        }
        try {
            $params = $this->getParams($params);
            $ret    = SysChannelModel::insert($params);
            if (!$ret) {
                exception('添加渠道失败', 400);
            }
        } catch (\Exception $e) {
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $e->getMessage(), $matches)) {
                $this->error('添加渠道失败！渠道号重复，请核实');
            } else {
                $this->error($e->getMessage());
            }
        }
        $this->success('成功');
    }

    /**
     * 编辑渠道
     * @ApiSummary  (dyrun/sys_channel/editchannel)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (POST)
     * @ApiBody ({
    'id': '1',
    'channel_name': '中国银行上海支行',
    'channel_num': 'ZH002',
    'country_ids': '1,2,3',
    'product_type_ids': '33,34',
    'coin_ids': '1,2',
    'pay_way_ids': '25,26',
    'billing_ids': '29,30',
    'out_pay_way_ids': '25,26',
    'pay_rate': 10.00,
    'status': 1,
    'margin_balance': 100000.00,
    'balance': 0.00,
    })
     * @param int $id  ID
     * @param string $channel_name  渠道名称
     * @param string $channel_num  渠道号
     * @param string $country_ids  国家多选
     * @param string $product_type_ids  支持产品类型
     * @param string $coin_ids  代收货币
     * @param string $pay_way_ids  代收支付方式
     * @param string $billing_ids  结算周期ID
     * @param string $out_pay_way_ids  代付支付方式
     * @param decimal $pay_rate  通道费率
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param decimal $margin_balance  保证金
     * @param decimal $balance  余额
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function editChannel()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysChannel');
        if (!$validate->scene('edit')->check($params)) {
            $this->error($validate->getError());
        }
        $params = $this->getParams($params);
        $ret    = SysChannelModel::update($params, [
            'id' => $params['id']
        ]);
        if (!$ret) {
            $this->error('编辑渠道失败，请稍后重试');
        }
        $this->success('编辑成功');
    }


    /**
     * 更新渠道状态
     * @ApiSummary  (dyrun/sys_channel/updatestatus)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (POST)
     * @ApiBody ({
    'id': '1',
    'status': 1,
    })
     * @param int $id  ID
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function updateStatus()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysChannel');
        if (!$validate->scene('updateStatus')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            $ret = SysChannelModel::update($params, [
                'id' => $params['id']
            ]);
            if (!$ret) {
                exception('更新渠道状态失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('更新渠道状态成功');
    }

    /**
     * ${CARET}
     * @param $params
     * @return mixed
     * @author hsy 2023-11-27
     */
    private function getParams($params)
    {
        $params['country_ids']      = is_array($params['country_ids']) ? implode(',', $params['country_ids']) : '';
        $params['product_type_ids'] = is_array($params['product_type_ids']) ? implode(',', $params['product_type_ids']) : '';
        $params['coin_ids']         = is_array($params['coin_ids']) ? implode(',', $params['coin_ids']) : '';
        $params['pay_way_ids']      = is_array($params['pay_way_ids']) ? implode(',', $params['pay_way_ids']) : '';
        $params['billing_ids']      = is_array($params['billing_ids']) ? implode(',', $params['billing_ids']) : '';
        $params['out_pay_way_ids']  = is_array($params['out_pay_way_ids']) ? implode(',', $params['out_pay_way_ids']) : '';
        return $params;
    }

}
