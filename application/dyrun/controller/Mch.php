<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use app\common\model\SysOptionValue;
use app\common\model\User;
use app\dyrun\service\BaseData;
use app\dyrun\service\MchService;
use think\Exception;
use think\Request;
use think\Validate;

/**
 * 商户管理
 */
class Mch extends Api
{
    protected $noNeedLogin = ['searchAccount', 'createAccount', 'createMch'];
    protected $noNeedRight = '*';


    /**
     * @throws Exception
     */
    public function createMch(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|chsDash',
            'merchant_type' => 'require|number|in:1,2',
            'merchant_name' => 'require|in:1,2',
            'country_id' => 'require|number',
            'agent_user_id' => 'number',
            'rate_in' => 'float',
            'rate_out' => 'float',
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new User(), 'id', $request->post('user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('user_id'));
        }
        if (!BaseData::isValueExistsModel(new SysOptionValue(), 'value', $request->post('country_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('country_id'));
        }
        if ($request->post('agent_user_id') and !BaseData::isValueExistsModel(new User(), 'id', $request->post('agent_user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('agent_user_id'));
        }
        dump($request->post());
        $this->success(__('Sign up successful'), []);
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