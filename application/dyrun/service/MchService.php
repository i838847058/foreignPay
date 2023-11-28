<?php

namespace app\dyrun\service;

use app\admin\model\User;
use app\common\model\Merchant;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Paginator;

class MchService
{
    /**
     * @param string $account_text
     * @param int $role
     * @return bool|\PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getMchAccountList(string $account_text, int $role = 0)
    {
        return User::field('id,username')->select(function ($query) use ($role, $account_text) {
            $query->where('status', 'normal');
            $query->where('username', 'like', $account_text . '%');
            if ($role != 0) {
                $query->where('role_id', $role);
            }
        });
    }

    /**
     * @param array $data
     * @return Merchant
     * @throws Exception
     */
    public function newMchOne(array $data): Merchant
    {
        $merchant = new Merchant();
        $data['merchant_no'] = BaseData::makeMerchantNo($data['user_id']);
        $data['api_key'] = BaseData::makeKeyMd5($data['merchant_no']);
        $data['agent_rate_in'] = $data['agent_user_id'] ? $data['agent_rate_in'] : 0;
        $data['agent_rate_out'] = $data['agent_user_id'] ? $data['agent_rate_out'] : 0;
        $result = $merchant->validate(
            [
                'user_id' => 'require|chsDash',
                'merchant_name' => 'require|chsDash|unique:merchant',
                'merchant_type' => 'require|number|in:1,2',
                'merchant_no' => 'require|number|unique:merchant',
                'countrys' => 'require|array',
                'agent_user_id' => 'number',
                'agent_rate_in' => 'float',
                'agent_rate_out' => 'float',
                'product_type_id' => 'require|number',
                'product_name' => 'require|chsDash|unique:merchant',
                'pay_way_id' => 'require|number',
                'coins_in' => 'require|array',
                'fee_rate_in' => 'require|float',
                'coins_out' => 'require|array',
                'fee_rate_out' => 'require|float'
            ]
        )->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            throw new Exception($merchant->getError());
        }
        $data = Merchant::get($merchant->id);
        unset($data->api_key);
        unset($data->id);
        return $data;
    }

    /**
     * @param int $rows
     * @param int $page
     * @param int $mch_type
     * @return Paginator
     * @throws DbException
     */
    public function getMchList(int $rows = 20, int $page = 1, int $mch_type): \think\Paginator
    {
        $data = Merchant::order('id', 'desc')
            ->where(function ($query) use ($mch_type) {
                if ($mch_type != 0) {
                    $query->where('merchant_type', $mch_type);
                }
            })
            ->paginate($rows, false, [
                'page' => $page
            ]);;
        $data->each(function ($item) {
            unset($item->id);
            unset($item->api_key);
        });
        return $data;
    }
}