<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\dyrun\service\BaseData;
use app\dyrun\service\MchService;
use app\dyrun\service\SysChannelService;
use app\dyrun\service\SysRunService;
use think\Loader;


/**
 * 运营管理-支付配置
 */
class SysRun extends Api
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';
    private   $mchService;
    private   $sysChannelService;
    private   $sysRunService;
    private   $baseDataService;

    public function __construct(MchService $mchService, SysChannelService $sysChannelService, SysRunService $sysRunService, BaseData $baseDataService)
    {
        parent::__construct();
        $this->mchService        = $mchService;
        $this->sysChannelService = $sysChannelService;
        $this->sysRunService     = $sysRunService;
        $this->baseDataService   = $baseDataService;
    }

    /**
     * 获取支付配置列表
     * @ApiSummary  (dyrun/sys_run/getSysRunList)
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
     * @param int $merchant_id   商户信息表ID
     * @param int $sys_channel_id  第三方支付渠道信息表ID
     * @param int $product_type_id  产品ID
     * @param string $product_name  产品名称
     * @param timestamp $created  创建时间
     * @param timestamp $updated  更新时间
     * @param int $rows  每页条数
     * @param int $page  页数
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function getSysRunList()
    {
        $params = $this->request->get();
        try {
            $datas = $this->sysRunService->getSysRun($params);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

    /**
     * 添加支付配置
     * @ApiSummary  (dyrun/sys_run/addRun)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (POST)
     * @ApiBody ({
    'merchant_id': '商户信息表ID',
    'sys_channel_id': '第三方支付支付配置信息表ID',
    'status': 0,
    'weigh': 1,
    })
     * @param string $merchant_id  商户信息表ID
     * @param string $sys_channel_id  第三方支付支付配置信息表ID
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param int $weigh  权重：越小越优先排；权重相同则轮询
     * @param decimal $single_day_limit_money  单日限额
     * @param decimal $single_limit_money  单笔限额
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function addRun()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysRun');
        if (!$validate->scene('add')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            // 判断商家ID
            if (!$this->baseDataService::isValueExistsModel(new \app\common\model\Merchant(), 'id', $params['merchant_id'])) {
                exception('选择的商家记录不存在，请核实', 400);
            }
            // 判断渠道ID
            if (!$this->baseDataService::isValueExistsModel(new \app\dyrun\model\SysChannel(), 'id', $params['sys_channel_id'])) {
                exception('选择的渠道记录不存在，请核实', 400);
            }
            $ret = $this->sysRunService->addSysRun($params);
            if (!$ret) {
                exception('添加支付配置失败', 400);
            }
        } catch (\Exception $e) {
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $e->getMessage(), $matches)) {
                $this->error('失败！支付配置重复，请核实');
            } else {
                $this->error($e->getMessage());
            }
        }
        $this->success('成功');
    }

    /**
     * 编辑支付配置
     * @ApiSummary  (dyrun/sys_run/editRun)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (POST)
     * @ApiBody ({
    'id': 1,
    'merchant_id': 1,
    'sys_channel_id': 1,
    'status': 0,
    'weigh': 0,
    'single_day_limit_money': 0,
    'single_limit_money': 0
    })
     * @param int $id  ID
     * @param string $merchant_id  商户信息表ID
     * @param string $sys_channel_id  第三方支付支付配置信息表ID
     * @param tinyint $status  状态：0=禁用；1=启用；
     * @param int $weigh  权重：越小越优先排；权重相同则轮询
     * @param decimal $single_day_limit_money  单日限额
     * @param decimal $single_limit_money  单笔限额
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function editRun()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysRun');
        if (!$validate->scene('edit')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            $ret = $this->sysRunService->editSysRun($params);
            if ($ret === false) {
                exception('编辑支付配置失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('编辑成功');
    }

    /**
     * 支付配置开关
     * @ApiSummary  (dyrun/sys_run/updatestatus)
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
        $validate = Loader::validate('SysRun');
        if (!$validate->scene('updateStatus')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            $ret = $this->sysRunService->editSysRun($params);
            if ($ret === false) {
                exception('更新渠道状态失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('更新渠道状态成功');
    }

    /**
     * 根据商户名称-获取商户配置信息
     * @ApiSummary  (dyrun/sys_run/getMerchants)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'merchant_name': '商户名称',
    })
     * @param string $merchant_name  商户名称
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function getMerchants()
    {
        $params = $this->request->get();
        try {
            $merchant_name = $params['merchant_name'] ?? '';
            $datas         = $this->mchService->getMchNoList($merchant_name);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

    /**
     * 根据支付配置名称-获取支付配置信息
     * @ApiSummary  (dyrun/sys_run/getChannels)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'channel_name': '支付配置名称',
    })
     * @param string $channel_name  支付配置名称
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function getChannels()
    {
        $params = $this->request->get();
        try {
            $channel_name = $params['channel_name'] ?? '';
            $datas        = $this->sysChannelService->getChannelByChannelName($channel_name);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

}
