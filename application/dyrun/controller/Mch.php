<?php

namespace app\dyrun\controller;

use app\admin\command\Api;
use think\Request;

class Mch extends Api
{
    protected $noNeedLogin = ['get','post'];
    protected $noNeedRight = '*';

    public function new(Request $request){

    }
}