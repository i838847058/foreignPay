<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use think\Request;
use think\Validate;

/**
 * 商户管理
 */
class Mch extends Api
{
    protected $noNeedLogin = ['get', 'account'];
    protected $noNeedRight = '*';

    public function account(Request $request)
    {
        $validate = new Validate([
            'username' => 'require|chsDash',
            'password' => 'require|chsDash',
            'role' => 'require|in:1,2'
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
        $ret = $this->auth->register($request->post('username'), $request->post('password'), null, null, ['role_id' => $request->post('role')]);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }
}