<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\dyrun\service\BaseData;
use think\Request;
use think\Validate;

class Option extends Api
{
    protected $noNeedLogin = ['get'];
    protected $noNeedRight = '*';

    /**
     * 配置获取
     * @ApiSummary  (dyrun/option/get)
     * @ApiMethod (GET)
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':{},
    })
     */
    public function get(Request $request)
    {
        $validate = new Validate([
            'name' => 'chsDash'
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $name = $request->get('name');
        $service = new BaseData();
        $list = $service->getConfigByName($name);
        $this->success('get success', $list);
    }
}