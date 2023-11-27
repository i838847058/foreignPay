<?php

namespace app\dyrun\service;

use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use think\Exception;

class BaseData
{
    /**
     * @param string|null $name
     * @return array
     * @throws Exception
     */
    public function getConfigByName(string $name = null): array
    {
        try {
            $model = SysOption::all(function ($query) use ($name) {
                $query->where('state', 1);
                if (!empty($name)) {
                    $query->where('name', $name);
                }
            });
            $list = [];
            foreach ($model as $item) {
                $list[] = [
                    $item->name => SysOptionValue::where('oid', $item->id)->column('id,value')
                ];
            }
            return $list;
        } catch (\think\exception\DbException $e) {
            throw new Exception($e->getMessage());
        }
    }
}