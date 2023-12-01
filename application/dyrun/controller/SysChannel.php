<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\dyrun\model\SysChannel as SysChannelModel;
use think\Loader;
use app\dyrun\service\SysChannelService;

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
    'channel_num': 'ZH001',
    'created': '2023-11-22 18:04:09',
    'updated': '2023-11-22 18:04:09',
    'rows': 10,
    'page': 1,
    })
     * @param string $channel_name  渠道名称
     * @param string $channel_num  渠道号
     * @param timestamp $created_start  创建时间-开始
     * @param timestamp $created_end  创建时间-结束
     * @param int $rows  每页条数
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
            $SysChannelService = new SysChannelService();
            $datas             = $SysChannelService->getSysChannelList($params);
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
    'channel_name':'payhuayu-巴西',
    'channel_num':'ZH002',
    'country_ids':'5,7,9',
    'coin_ids':'1,2',
    'product_type_id':'33',
    'pay_way_id':'25',
    'billing_id':'29',
    'is_u':25,
    'pay_rate':10.0,
    'status':1,
    'margin_balance':100000.0,
    'balance':0.0,
    })
     * @param string $channel_name  渠道名称
     * @param string $channel_num  渠道号
     * @param string $country_ids  国家-多选
     * @param string $coin_ids  代收货币-多选
     * @param string $product_type_id  支持产品类型
     * @param string $pay_way_id  代收支付方式
     * @param string $billing_id  结算周期ID
     * @param tinyint $is_u  状态：0=否；1=是；
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
            $ret    = (new \app\dyrun\model\SysChannel)->insert($params);
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
    'id':1,
    'channel_name':'payhuayu-巴西',
    'channel_num':'ZH002',
    'country_ids':'5,7,9',
    'coin_ids':'1,2',
    'product_type_id':'33',
    'pay_way_id':'25',
    'billing_id':'29',
    'is_u':25,
    'pay_rate':10.0,
    'status':1,
    'margin_balance':100000.0,
    'balance':0.0,
    })
     * @param int $id  ID
     * @param string $channel_name  渠道名称
     * @param string $channel_num  渠道号
     * @param string $country_ids  国家-多选
     * @param string $coin_ids  代收货币-多选
     * @param string $product_type_id  支持产品类型
     * @param string $pay_way_id  代收支付方式
     * @param string $billing_id  结算周期ID
     * @param tinyint $is_u  状态：0=否；1=是；
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
        try {
            $params = $this->getParams($params);
            $ret    = (new \app\dyrun\model\SysChannel)->allowField(true)->save($params, [
                'id' => $params['id']
            ]);
            if ($ret === false) {
                exception('编辑渠道失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
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
            $ret = (new \app\dyrun\model\SysChannel)->allowField(true)->save($params, [
                'id' => $params['id']
            ]);
            if ($ret === false) {
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
        $params['country_ids'] = is_array($params['country_ids']) ? implode(',', $params['country_ids']) : '';
        $params['coin_ids']    = is_array($params['coin_ids']) ? implode(',', $params['coin_ids']) : '';
        return $params;
    }

}
