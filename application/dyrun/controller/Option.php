<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use think\Request;
use think\Validate;

class Option extends Api
{
    protected $noNeedLogin = ['get'];
    protected $noNeedRight = '*';

    public function get(Request $request)
    {
        $validate = new Validate([
            'name' => 'require'
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $name = $request->get('name');
        $model = SysOption::all(function ($query) use ($name) {
            $query->where('state', 1);
            if (!empty($name)) {
                $query->where('name', $name);
            }
        });
        $list = [];
        foreach ($model as $item) {
            $list[] = [
                'name' => $item->name,
                'value' => SysOptionValue::where('oid', $item->id)->column('id,value')
            ];
        }
        $this->success('get success', $list);
    }
}