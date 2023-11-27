<?php

namespace app\dyrun\service;

use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use think\Exception;

class BaseData
{
    /**
     * @param string|null $name
     * @param string|null $value
     * @return array
     * @throws Exception
     */
    public function getConfigValue(string $name = null, string $value = null): array
    {
        try {
            $list = [];
            $model = SysOption::all(function ($query) use ($name, $value) {
                $query->where('state', 1);
                if (!empty($name)) {
                    $query->where('name', $name);
                }
            });
            foreach ($model as $item) {
                $oid = $item->id;
                $list[$item->name] = SysOptionValue::field('id,value,remark')->select(function ($query) use ($oid, $value) {
                    $query->where('oid', $oid);
                    if (!empty($value)) {
                        $query->where('value', 'like', '%' . $value . '%');
                    }
                });
            }
            return $list;
        } catch (\think\exception\DbException $e) {
            throw new Exception($e->getMessage());
        }
    }
}