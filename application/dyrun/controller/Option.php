<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\common\model\SysOption;
use app\dyrun\service\BaseData;
use think\Request;
use think\Validate;

/**
 * 配置管理
 */
class Option extends Api
{
    protected $noNeedLogin = ['get'];
    protected $noNeedRight = '*';

    /**
     * 统一获取
     * @ApiSummary  (dyrun/option/get)
     * @ApiMethod (GET)
     * @ApiParams   (name="name", type="string", required=true, description="name为_index的key值")
     * @ApiParams   (name="value", type="string", required=true, description="value为模糊索引值")
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':{
    },
    })
     */
    public function get(Request $request)
    {
        $validate = new Validate([
            'name' => 'chsDash',
            'value' => 'chsDash'
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $name = $request->get('name');
        $value = $request->get('value');
        $service = new BaseData();
        $list['_index'] = SysOption::where('state', 1)->column('remark', 'name');
        $list['_list'] = $service->getConfigValue($name, $value);
        $this->success('get success', $list);
    }
}