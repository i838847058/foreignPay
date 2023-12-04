<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use think\Loader;
use app\dyrun\service\SysRateCfgService;
use app\dyrun\service\BaseData;



/**
 * 基础数据-汇率
 */
class SysRateCfg extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    private   $baseDataService;

    private $sysRateCfgService;

    public function __construct(SysRateCfgService $sysRateCfgService,BaseData $baseDataService)
    {
        parent::__construct();
        $this->sysRateCfgService = $sysRateCfgService;
        $this->baseDataService   = $baseDataService;
    }

    /**
     * 获取列表
     * @ApiSummary  (dyrun/sys_rate_cfg/getSysRateList)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'id': 1,
    'name': '中文名字',
    })
     * @param string $name  中文名字
     * @ApiReturn ({
    'code': 1,
    'msg': '',
    'time': '1700731394',
    'data': {
    '241': '中非共和国',
    '242': '中国'
    }
    })
     * 这样的操作对于大量数据是非常低效的，但是在数据量小的情况下可以使用。
     */
    public function getSysRateList()
    {
        $params = $this->request->get();
        try {
            $datas = $this->sysRateCfgService->getSysRate($params);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

    /**
     * 新增汇率
     * @ApiSummary  (dyrun/sys_rate_cfg/addSysRate)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'coin_id ': 1,
    'rate ': 7.32,
    'status ': 1
    })
     * @param string $name  中文名字
     * @ApiReturn ({
    'code': 1,
    'msg': '',
    'time': '1700731394',
    'data': {}
    })
     */
    public function addSysRate()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysRateCfg');
        if (!$validate->scene('add')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            // 判断币种ID
            if (!$this->baseDataService::isValueExistsModel(new \app\common\model\SysOptionValue(), 'id', $params['coin_id'])) {
                exception('选择的币种记录不存在，请核实', 400);
            }
            $ret = $this->sysRateCfgService->addSysRate($params);
            if (!$ret) {
                exception('添加汇率失败', 400);
            }
        } catch (\Exception $e) {
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $e->getMessage(), $matches)) {
                $this->error('添加汇率失败！汇率号重复，请核实');
            } else {
                $this->error($e->getMessage());
            }
        }
        $this->success('成功');
    }

    /**
     * 获取列表
     * @ApiSummary  (dyrun/sys_rate_cfg/editSysRate)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'id': 1,
    })
     * @param int $id  ID
     * @param int $coin_id  币种ID
     * @ApiReturn ({
    'code': 1,
    'msg': '',
    'time': '1700731394',
    'data': {}
    })
     * 这样的操作对于大量数据是非常低效的，但是在数据量小的情况下可以使用。
     */
    public function editSysRate()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('SysRateCfg');
        if (!$validate->scene('edit')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            $ret = $this->sysRateCfgService->editSysRate($params);
            if ($ret === false) {
                exception('编辑汇率失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $e->getMessage(), $matches)) {
                $this->error('编辑汇率失败！汇率号重复，请核实');
            } else {
                $this->error($e->getMessage());
            }
        }
        $this->success('成功');
    }

    /**
     * 支付配置开关
     * @ApiSummary  (dyrun/sys_rate_cfg/updatestatus)
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
        $validate = Loader::validate('SysRateCfg');
        if (!$validate->scene('updateStatus')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            $ret = $this->sysRateCfgService->editSysRate($params);
            if ($ret === false) {
                exception('更新汇率状态失败，请稍后重试', 400);
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('更新汇率状态成功');
    }


}
