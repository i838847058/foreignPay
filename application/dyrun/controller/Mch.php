<?php

namespace app\dyrun\controller;

use app\admin\library\Auth;
use app\common\controller\Api;
use app\common\model\Merchant;
use app\common\model\SysCountryCoinsView;
use app\common\model\SysOptionValue;
use app\common\model\User;
use app\dyrun\service\BaseData;
use app\dyrun\service\MchService;
use fast\Random;
use think\Exception;
use think\exception\DbException;
use think\Request;
use think\Validate;

/**
 * 商户管理
 */
class Mch extends Api
{
    protected $noNeedLogin = ['searchAccount', 'getMchList', 'createAccount', 'removeAccount', 'createMch', 'getAccountList', 'changeAccountPassword'];
    protected $noNeedRight = '*';

    public function getMchList(Request $request)
    {
        $this->success(__('Sign up successful'));
    }

    public function createMch(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|chsDash',
            'merchant_name' => 'require|chsDash|unique:merchant',
            'merchant_type' => 'require|number|in:1,2',
            'countrys' => 'require|array',
            'agent_user_id' => 'number',
            'agent_rate_in' => 'float|between:0,10',
            'agent_rate_out' => 'float|between:0,10',
            'product_type_id' => 'require|number',
            'product_name' => 'require|chsDash|unique:merchant',
            'pay_way_id' => 'require|number',
            'coins_in' => 'require|array',
            'fee_rate_in' => 'require|float|between:0,100',
            'coins_out' => 'require|array',
            'fee_rate_out' => 'require|float|between:0,100',
            'deposit_rate' => 'require|float|between:0,100',
        ]);
        $input = $request->post();
        if (!$validate->check($input)) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new User(), 'id', $request->post('user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('user_id'));
        }
        foreach ($input['countrys'] as $countrys) {
            if (!BaseData::isValueExistsModel(new SysCountryCoinsView(), 'country_id', $countrys)) {
                $this->error($this->NOT_EXISTS_MODEL_MSG('country:' . $countrys));
            }
        }
        foreach ($input['coins_in'] as $countrys) {
            if (!BaseData::isValueExistsModel(new SysCountryCoinsView(), 'currency_id', $countrys)) {
                $this->error($this->NOT_EXISTS_MODEL_MSG('country:' . $countrys));
            }
        }
        foreach ($input['coins_out'] as $countrys) {
            if (!BaseData::isValueExistsModel(new SysCountryCoinsView(), 'currency_id', $countrys)) {
                $this->error($this->NOT_EXISTS_MODEL_MSG('country:' . $countrys));
            }
        }
        if (!BaseData::isValueExistsModel(new SysOptionValue(), 'id', $request->post('product_type_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('agent_user_id'));
        }
        if (!BaseData::isValueExistsModel(new SysOptionValue(), 'id', $request->post('pay_way_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('agent_user_id'));
        }
        if ($request->post('agent_user_id') and !BaseData::isValueExistsModel(new User(), 'id', $request->post('agent_user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('agent_user_id'));
        }
        if ($request->post('agent_user_id') and (!$request->post('agent_rate_in') or !!$request->post('agent_rate_in'))) {
            $this->error('miss agent_rate_in or agent_rate_out.');
        }
        $service = new MchService();
        $infos = $service->newMchOne($request->post());
        $this->success(__('Sign up successful'), $infos);
    }

    /**
     * @throws Exception
     */
    public function removeAccount(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|number',
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new User(), 'id', $request->post('user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('user_id'));
        }
        // 检查商户号
        if (($count = Merchant::where('user_id', $request->post('user_id'))->count()) > 0) {
            $this->error('merchant need remove first.', ['mch_count' => $count]);
        }
        User::get($request->post('user_id'))->delete();
        $this->success(__('remove Account successful'));
    }

    public function changeAccountPassword(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|number',
            'password' => 'require|chsDash|min:6|max:50',
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new User(), 'id', $request->post('user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('user_id'));
        }
        // 获取用户
        $user = User::get($request->post('user_id'));
        $authService = new Auth();
        $salt = Random::alnum();
        $password = $authService->getEncryptPassword($request->post('password'), $salt);
        $user->save(['loginfailure' => 0, 'password' => $password, 'salt' => $salt]);
        $this->success(__('change Account Password successful'));
    }

    public function getAccountList(Request $request)
    {
        try {
            $list = User::field('id,role_id as role,username,nickname,logintime,loginip,createtime,updatetime')
                ->where('role_id', '>', 0)
                ->order('id', 'desc')
                ->paginate($request->get('rows', 20), false, [
                    'page' => $request->get('page', 1)
                ]);
            foreach ($list as $key => $item) {
                $item->logintime = date('Y-m-d H:i:s', $item->logintime);
                $item->createtime = date('Y-m-d H:i:s', $item->createtime);
                $item->updatetime = date('Y-m-d H:i:s', $item->updatetime);
            }
            $this->success(__('Get Account List successful'), $list);
        } catch (DbException $e) {
            $this->error($e->getMessage());
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
            'role' => 'in:0,1,2',
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $service = new MchService();
        $data = $service->getMchAccountList($request->get('text'), $request->get('role', 0));
        $this->success(__('Searching successful'), $data);
    }
}