<?php

namespace app\dyrun\service;

use app\admin\model\User;
use app\common\model\Merchant;
use app\common\model\SysCountryCoinsView;
use app\common\model\SysOption;
use app\common\model\SysOptionValue;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Paginator;

class MchService
{
    /**
     * @param string $text
     * @param int $rows
     * @param int $role
     * @return bool|\PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getMchAccountList(string $text, int $rows, int $role = 0)
    {
        return User::field('id,username')->select(function ($query) use ($rows, $role, $text) {
            $query->where('status', 'normal');
            if ($text) {
                $query->where('username', 'like', $text . '%');
            }
            if ($role != 0) {
                $query->where('role_id', $role);
            }
            if ($rows != 0 and $rows > 0) {
                $query->limit($rows);
            }
        });
    }

    /**
     * @param string $text
     * @param int $user_id
     * @return bool|\PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getMchNoList(string $text, int $user_id = 0)
    {
        return Merchant::field('id,merchant_no,merchant_name')->select(function ($query) use ($user_id, $text) {
            $query->where('status', 1)->where('merchant_name', 'like', $text . '%');
            if ($user_id != 0) {
                $query->where('user_id', $user_id);
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
        if ($data['agent_rate_in'] ?? 0 and $data['agent_rate_out'] ?? 0) {
            $data['agent_rate_in'] = $data['agent_user_id'] ? $data['agent_rate_in'] : 0;
            $data['agent_rate_out'] = $data['agent_user_id'] ? $data['agent_rate_out'] : 0;
        }
        $result = $merchant->validate(Merchant::VALIDATE)->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            throw new Exception($merchant->getError());
        }
        $data = Merchant::get($merchant->id);
        unset($data->api_key);
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
            $item->countrys_text = '';
            foreach ($item->countrys as $id) {
                $item->countrys_text .= SysCountryCoinsView::get($id)->value('country_name') . '，';
            }
            $item->countrys_text = mb_substr($item->countrys_text, 0, -1);
            $item->coins_in_text = '';
            foreach ($item->coins_in as $id) {
                $item->coins_in_text .= SysCountryCoinsView::get($id)->value('currency_name') . '，';
            }
            $item->coins_in_text = mb_substr($item->coins_in_text, 0, -1);
            $item->coins_out_text = '';
            foreach ($item->coins_out as $id) {
                $item->coins_out_text .= SysCountryCoinsView::get($id)->value('currency_name') . '，';
            }
            $item->coins_out_text = mb_substr($item->coins_out_text, 0, -1);
            unset($item->api_key);
        });
        return $data;
    }

    /**
     * @param Merchant $merchant
     * @param string $key
     * @param $value
     * @return bool
     */
    public function updateMchUserInfo(Merchant $merchant, string $key, $value): bool
    {
        if (in_array($key, Merchant::UPDATE_FIELD) and $merchant->id ?? 0 and
            $merchant->validate([
                $key => Merchant::VALIDATE[$key] ?? ''
            ])->save([
                $key => $value
            ])) {
            return true;
        }
//        throw new Exception($merchant->getError());
        return false;
    }
}