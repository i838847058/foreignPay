<?php

namespace app\dyrun\service;

use app\admin\model\User;
use app\common\model\Merchant;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;

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

    public function newMchOne(array $data): array
    {
        $merchant = new Merchant();
        $data['merchant_no'] = BaseData::makeMerchantNo($data['user_id']);
        $data['rate_in'] = $data['agent_user_id'] ? $data['rate_in'] : 0;
        $data['rate_out'] = $data['agent_user_id'] ? $data['rate_out'] : 0;
        $result = $merchant->validate(
            [
                'user_id' => 'require|chsDash',
                'merchant_name' => 'require|chsDash|unique:merchant',
                'merchant_type' => 'require|number|in:1,2',
                'merchant_no' => 'require|number|unique:merchant',
                'country_id' => 'require|number',
                'agent_user_id' => 'number',
                'rate_in' => 'float',
                'rate_out' => 'float',
            ]
        )->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            throw new Exception($merchant->getError());
        }
        return $data;
    }
}