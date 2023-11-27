<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\dyrun\service\MchService;
use think\Request;
use think\Validate;

/**
 * 商户管理
 */
class Mch extends Api
{
    protected $noNeedLogin = ['searchAccount', 'createAccount', 'createMch'];
    protected $noNeedRight = '*';

    public function createMch(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|chsDash',
            'merchant_type' => 'require|chsDash',
            'merchant_name' => 'require|in:1,2',
            'country_id' => 'require|in:1,2',
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
    }

    public function createAccount(Request $request)
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

    public function searchAccount(Request $request)
    {
        $validate = new Validate([
            'text' => 'require|chsDash',
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $service = new MchService();
        $data = $service->getMchAccountList($request->get('text'));
        $this->success(__('Searching successful'), $data);
    }
}