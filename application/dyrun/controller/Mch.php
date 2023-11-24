<?php

namespace app\dyrun\controller;

use app\admin\command\Api;
use think\Request;

class Mch extends Api
{
    protected $noNeedLogin = '';
    protected $noNeedRight = '*';

    public function new(Request $request){

    }
}