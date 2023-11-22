<?php

namespace app\common\behavior;

class OperateLog
{
    public function run(&$params)
    {
        //只记录POST请求的日志
        if (request()->isPost() && config('fastadmin.auto_record_log')) {
            $header = request()->header();
            if(isset($header['token'])){
                \app\common\model\OperateLog::record($header['token']);
            }
        }
    }
}
