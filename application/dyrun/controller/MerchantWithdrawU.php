<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use think\Loader;
use app\dyrun\service\MerchantWithdrawUService;
use app\dyrun\service\BaseData;
use app\dyrun\service\MchService;


/**
 * 商户提U
 */
class MerchantWithdrawU extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    /*private BaseData $baseDataService;

    private MchService $mchService;

    private MerchantWithdrawUService $merchantWithdrawUService;*/

    public function __construct(MerchantWithdrawUService $merchantWithdrawUService, BaseData $baseDataService, MchService $mchService)
    {
        parent::__construct();
        $this->mchService               = $mchService;
        $this->merchantWithdrawUService = $merchantWithdrawUService;
        $this->baseDataService          = $baseDataService;
    }

    /**
     * 获取列表
     * @ApiSummary  (dyrun/merchant_withdrawal_u/getList)
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
    public function getList()
    {
        $params = $this->request->get();
        try {
            $datas = $this->merchantWithdrawUService->getSysRate($params);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }

    /**
     * 新增提U记录
     * @ApiSummary  (dyrun/merchant_withdrawal_u/add)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'coin_id ': 1,
    'rate ': 7.32,
    'status ': 1
    })
     * @param string $name  中文名字
     * @param tinyint $status  状态：-4=审核拒绝；0=已申请；1=审核成功；2=已打款；
     * @ApiReturn ({
    'code': 1,
    'msg': '',
    'time': '1700731394',
    'data': {}
    })
     */
    public function add()
    {
        if (!$this->request->isPost()) {
            $this->error('请求异常，请核实');
        }
        $params   = $this->request->post();
        $validate = Loader::validate('MerchantWithdrawU');
        if (!$validate->scene('add')->check($params)) {
            $this->error($validate->getError());
        }
        try {
            // 判断币种ID
            if (!$this->baseDataService::isValueExistsModel(new \app\common\model\SysOptionValue(), 'id', $params['coin_id'])) {
                exception('选择的币种记录不存在，请核实', 400);
            }
            $this->merchantWithdrawUService->addSysRate($params);
        } catch (\Exception $e) {
            if (preg_match("/.+Integrity constraint violation: 1062 Duplicate entry '(.+)' for key '(.+)'/is", $e->getMessage(), $matches)) {
                $this->error('添加提U记录失败！提U记录号重复，请核实');
            } else {
                $this->error($e->getMessage());
            }
        }
        $this->success('成功');
    }

    public function getMerchantBalanceList()
    {
        $lists = $this->mchService->getMerchantBalanceList();
        $this->success('', $lists);
    }


}
