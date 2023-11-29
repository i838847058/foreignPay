<?php

namespace app\common\model;

use think\exception\DbException;
use think\Model;

class SysOptionValue extends Model
{
    protected $field = ['oid', 'value', 'remark'];

    public static function getValue($id)
    {
        try {
            return self::get($id)->value('value');
        } catch (DbException $e) {
        }
    }

}
