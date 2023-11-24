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