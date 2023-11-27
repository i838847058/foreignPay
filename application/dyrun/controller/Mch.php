<?php

namespace app\dyrun\controller;

use app\common\controller\Api;
use think\Request;

class Mch extends Api
{
    protected $noNeedLogin = ['get', 'account'];
    protected $noNeedRight = '*';

    public function account(Request $request, $option)
    {
//        $ret = $this->auth->register(1, 2);
        dump($option);
    }
}