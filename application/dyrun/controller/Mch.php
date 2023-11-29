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
    protected $noNeedLogin = ['updateMchInfo', 'searchAccount', 'getMchList', 'createAccount', 'changeAccountMchStatus', 'createMch', 'getAccountList', 'changeAccountPassword'];
    protected $noNeedRight = '*';

    public function getMchList(Request $request)
    {
        $validate = new Validate([
            'rows' => 'require|number',
            'page' => 'require|number',
            'merchant_type' => 'number|in:1,2',
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $service = new MchService();
        $list = $service->getMchList($request->get('rows'), $request->get('page'), $request->get('merchant_type', 0));
        $this->success(__('get Mch List successful'), $list);
    }

    public function updateMchInfo(Request $request)
    {
        $validate = new Validate([
            'id' => 'require|number',
            'key' => 'require',
            'value' => 'require',
        ]);
        $post = $request->post();
        if (!$validate->check($post)) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new Merchant(), 'id', $post['id'])) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('id'));
        }
        if (!$mch = Merchant::get($post['id'])) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('id'));
        }
        $service = new MchService();
        if ($service->updateMchUserInfo($mch, $post['key'], $post['value'])) {
            $this->success(__('update Mch Info successful'));
        }
        $this->error($validate->getError());
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
            'product_type_id' => 'number',
            'product_name' => 'chsDash',
            'pay_way_id' => 'number',
            'coins_in' => 'array',
            'fee_rate_in' => 'float|between:0,100',
            'coins_out' => 'array',
            'fee_rate_out' => 'float|between:0,100',
            'deposit_rate' => 'float|between:0,100',
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
        foreach ($input['coins_in'] ?? [] as $countrys) {
            if (!BaseData::isValueExistsModel(new SysCountryCoinsView(), 'currency_id', $countrys)) {
                $this->error($this->NOT_EXISTS_MODEL_MSG('country:' . $countrys));
            }
        }
        foreach ($input['coins_out'] ?? [] as $countrys) {
            if (!BaseData::isValueExistsModel(new SysCountryCoinsView(), 'currency_id', $countrys)) {
                $this->error($this->NOT_EXISTS_MODEL_MSG('country:' . $countrys));
            }
        }
        if ($request->post('product_type_id') and !BaseData::isValueExistsModel(new SysOptionValue(), 'id', $request->post('product_type_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('product_type_id'));
        }
        if ($request->post('pay_way_id') and !BaseData::isValueExistsModel(new SysOptionValue(), 'id', $request->post('pay_way_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('pay_way_id'));
        }
        if ($request->post('agent_user_id') and !BaseData::isValueExistsModel(new User(), 'id', $request->post('agent_user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('agent_user_id'));
        }
        if ($request->post('agent_user_id') and (!$request->post('agent_rate_in') or !$request->post('agent_rate_in'))) {
            $this->error('miss agent_rate_in or agent_rate_out.');
        }
        $service = new MchService();
        $infos = $service->newMchOne($request->post());
        $this->success(__('Sign up successful'), $infos);
    }

    /**
     * @throws Exception
     */
    public function changeAccountMchStatus(Request $request)
    {
        $validate = new Validate([
            'user_id' => 'require|number',
            'mch_status' => 'require|in:0,1',
        ]);
        if (!$validate->check($request->post())) {
            $this->error($validate->getError());
        }
        // 判断是否存在数据表
        if (!BaseData::isValueExistsModel(new User(), 'id', $request->post('user_id'))) {
            $this->error($this->NOT_EXISTS_MODEL_MSG('user_id'));
        }
        // 检查商户号
        $user = User::get($request->post('user_id'));
        $user->mch_status = $request->post('mch_status');
        $user->save();
        $this->success(__('change Account Mch Status successful'));
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
            $list = User::field('id,role_id as role,username,nickname,logintime,loginip,createtime,updatetime,mch_status')
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
            'rows' => 'number',
            'text' => 'chsDash',
            'role' => 'in:0,1,2',
        ]);
        if (!$validate->check($request->get())) {
            $this->error($validate->getError());
        }
        $service = new MchService();
        $data = $service->getMchAccountList($request->get('text', ''), $request->get('rows', 50), $request->get('role', 0));
        $this->success(__('Searching successful'), $data);
    }
}