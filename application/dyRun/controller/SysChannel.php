<?php

namespace app\dyRun\controller;

use app\common\controller\Api;
use app\dyRun\model\SysChannel as SysChannelModel;
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
    "channel_name': '中国银行上海支行',
    'channel_short_name': '中行',
    'channel_num': 'ZH001',
    'pay_product': 0,
    'trans_currency': '人民币',
    'country_id': 1,
    'support_product': '游戏、棋牌',
    'no_product': '黄，赌，毒',
    'pay_method': '线上',
    'pay_rate': '10.00',
    'settlement_cycle': 'T+1',
    'status': 1,
    'margin_balance': '100000.00',
    'created': '2023-11-22 18:04:09',
    'updated': '2023-11-22 18:04:09'
    })
     * @param string $channel_name  渠道名称
     * @param string $channel_short_name  渠道简称
     * @param string $channel_num  渠道号
     * @param tinyint $pay_product  支付产品：0=代收；1=代付；
     * @param string $trans_currency  交易货币
     * @param int $country_id  国家ID
     * @param string $support_product  支持产品
     * @param string $no_product  禁止产品
     * @param string $pay_method  支付方式
     * @param decimal $pay_rate  支付费率
     * @param string $settlement_cycle  结算周期
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param decimal $margin_balance  保证金余额
     * @param timestamp $created  创建时间
     * @param timestamp $updated  更新时间
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
            $ret = SysChannelModel::insert($params);
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
    'channel_short_name': '中行',
    'channel_num': 'ZH001',
    'pay_product': '游戏',
    'trans_currency': '人民币',
    'country_id': 1,
    'support_product_type_id': 1,
    'no_product': '黄，赌，毒',
    'pay_method': '线上',
    'pay_rate': '10.00',
    'settlement_cycle': 'T+1',
    'status': 1,
    'margin_balance': '100000.00',
    'created': '2023-11-22 18:04:09',
    'updated': '2023-11-22 18:04:09'
    })
     * @param int $id  ID
     * @param string $channel_name  渠道名称
     * @param string $channel_short_name  渠道简称
     * @param string $channel_num  渠道号
     * @param tinyint $pay_product  支付产品：0=代收；1=代付；
     * @param string $trans_currency  交易货币
     * @param int $country_id  国家ID
     * @param string $support_product  支持产品
     * @param string $no_product  禁止产品
     * @param string $pay_method  支付方式
     * @param decimal $pay_rate  支付费率
     * @param string $settlement_cycle  结算周期
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param decimal $margin_balance  保证金余额
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
        $ret = SysChannelModel::update($params, [
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
                $this->error('更新渠道状态失败，请稍后重试');
            }
            $this->success('更新渠道状态成功');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

}
