<?php

namespace app\dyRun\controller;

use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\captcha\Captcha;
use think\Config;
use think\Validate;

/**
 * 会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third', 'captcha'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }

    /**
     * 会员登录
     * @ApiSummary  (http://local.foreignpay.com/dyrun/user/login)
     * @ApiMethod (POST)
     * @ApiBody ({
    'username':'dy001',
    'password':'123456',
    'captcha':'fmyh'
    })
     * @param string $username  账号
     * @param string $password 密码
     * @param string $captcha 验证码
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':{},
    })
     */
    public function login()
    {
        $params   = $this->request->post();
        $username = $params['username'];
        $password = $params['password'];
        $captcha  = $params['captcha'];
        if (!$username || !$password || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (Config::get('fastadmin.login_captcha')) {
            $rule['captcha'] = 'require|captcha';
            $data['captcha'] = $captcha;
        }
        $validate = new Validate($rule, [], ['username' => __('Username'), 'password' => __('Password'), 'captcha' => __('Captcha')]);
        $result   = $validate->check($data);
        if (!$result) {
            $this->error($validate->getError());
        }
        $ret = $this->auth->login($username, $password);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 退出登录
     * @ApiMethod (POST)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiReturn {
     * "code": 401,
     * "msg": "请登录后操作",
     * "time": "1700547678",
     * "data": null
     * }
     */
    public function logout()
    {
        if (!$this->request->isPost()) {
            $this->error(__('Invalid parameters'));
        }
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 重置密码
     * @ApiMethod (POST)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     * @ApiReturn {
     *                            "code": 1,
     *                            "msg": "成功",
     *                            "time": "1700547678",
     *                            "data": null
     *                            }
     */
    private function resetpwd()
    {
        $type        = $this->request->post("type", "mobile");
        $mobile      = $this->request->post("mobile");
        $email       = $this->request->post("email");
        $newpassword = $this->request->post("newpassword");
        $captcha     = $this->request->post("captcha");
        if (!$newpassword || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        //验证Token
        if (!Validate::make()->check(['newpassword' => $newpassword], ['newpassword' => 'require|regex:\S{6,30}'])) {
            $this->error(__('Password must be 6 to 30 characters'));
        }
        if ($type == 'mobile') {
            if (!Validate::regex($mobile, "^1\d{10}$")) {
                $this->error(__('Mobile is incorrect'));
            }
            $user = \app\common\model\User::getByMobile($mobile);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Sms::check($mobile, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Sms::flush($mobile, 'resetpwd');
        } else {
            if (!Validate::is($email, "email")) {
                $this->error(__('Email is incorrect'));
            }
            $user = \app\common\model\User::getByEmail($email);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Ems::check($email, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Ems::flush($email, 'resetpwd');
        }
        //模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->auth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 验证码
     * @ApiSummary  (http://local.foreignpay.com/dyrun/common/captcha)
     * @param $id
     * @return \think\Response
     */
    public function captcha($id = "")
    {
        \think\Config::set([
            'captcha' => array_merge(config('captcha'), [
                'fontSize' => 44,
                'imageH'   => 150,
                'imageW'   => 350,
            ])
        ]);
        $captcha = new Captcha((array)Config::get('captcha'));
        return $captcha->entry($id);
    }

    /**
     * 注册会员
     * @ApiMethod (POST)
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email    邮箱
     * @param string $mobile   手机号
     * @param string $code     验证码
     */
    protected function register()
    {
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $email    = $this->request->post('email');
        $mobile   = $this->request->post('mobile');
        $code     = $this->request->post('code');
        if (!$username || !$password) {
            $this->error(__('Invalid parameters'));
        }
        if ($email && !Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $ret = Sms::check($mobile, $code, 'register');
        if (!$ret) {
            $this->error(__('Captcha is incorrect'));
        }
        $ret = $this->auth->register($username, $password, $email, $mobile, []);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

}
