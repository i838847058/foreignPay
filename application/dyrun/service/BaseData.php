<?php

namespace app\dyrun\service;

use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class BaseData
{
    /**
     * @param Model $model
     * @param string $columns
     * @param string $value
     * @return bool
     * @throws Exception
     */
    public function isValueExistsModel(Model $model, string $columns, string $value): bool
    {
        try {
            return $model->where($columns, $value)->count() > 0;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

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

    /**
     * @param $countryId
     * @return array|bool|\PDOStatement|string|Model|null
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function getCurrencyByCountry($countryId)
    {
        return Db::table('fp_sys_country_coins_view')->where('country_id', $countryId)->field('currency_id as id,currency_name as name')->find();
    }
}