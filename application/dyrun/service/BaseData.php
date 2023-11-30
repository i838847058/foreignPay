<?php

namespace app\dyrun\service;

use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use PDOStatement;
use think\Collection;
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
     * @param string|null $value
     * @return bool
     * @throws Exception
     */
    public static function isValueExistsModel(Model $model, string $columns, ?string $value): bool
    {
        try {
            return $model->where($columns, $value)->count() > 0;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $merchant_no
     * @return string
     */
    public static function makeKeyMd5(string $merchant_no): string
    {
        $value = $merchant_no . time();
        return md5($value);
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
     * @param string $countryId
     * @return array|bool|Collection|PDOStatement|string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getCurrencyByCountry(string $countryId)
    {
        if ($all = explode(',', $countryId) and is_array($all)) {
            $list = [];
            foreach ($all as $id) {
                if ($item = Db::table('fp_sys_country_coins_view')->where('country_id', $id)->field('currency_id as id,currency_name as name')->find()) {
                    $list[] = $item;
                }
            }
            return $list;
        }
        return Db::table('fp_sys_country_coins_view')->where('country_id', $countryId)->field('currency_id as id,currency_name as name')->select();
    }

    /**
     * @return bool|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getCountrys()
    {
        return Db::table('fp_sys_country_coins_view')->field('country_id as id,country_name as name')->select();
    }

    /**
     * @param $userId
     * @return string
     */
    public static function makeMerchantNo($userId): string
    {
        return "1000" . rand(10, 88) . "0" . $userId . "0" . rand(100, 888);
    }
}