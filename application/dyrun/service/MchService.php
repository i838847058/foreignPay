<?php

namespace app\dyrun\service;

use app\common\model\User;
use app\common\model\Merchant;
use app\common\model\SysCountryCoinsView;
use app\common\model\SysOptionValue;
use GuzzleHttp\Exception\GuzzleException;
use think\addons\Service;
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
     * @return array
     */
    public function getMchNoList(string $text, int $user_id = 0)
    {
        $SysChannelService = new \app\dyrun\service\SysChannelService();
        list($product_type_arr, $coin_arr, $pay_way_arr, $billing_arr, $country_arr) = $SysChannelService->getBaseOption();
        $where = [
            'status' => 1,
            'merchant_name' => ['like', "{$text}%"],
        ];
        if ($user_id) {
            $where['user_id'] = $user_id;
        }
        $merchants_data = [];
        Merchant::where($where)->chunk(200, function ($merchants)
        use (&$merchants_data, $country_arr, $coin_arr, $product_type_arr, $pay_way_arr, $billing_arr) {
            foreach ($merchants as $merchant) {
                // 支持产品类型
                $merchant['product_type_id_text'] = $product_type_arr[$merchant['product_type_id']] ?? '';
                // 支付方式-代收
                $merchant['pay_way_id_text'] = $pay_way_arr[$merchant['pay_way_id']] ?? '';
                // 货币-代收
                $coins_in = is_array($merchant['coins_in']) ? $merchant['coins_in'] : explode(',', $merchant['coins_in']);
                $merchant['coins_in_text'] = implode(',', array_intersect_key($coin_arr, array_flip($coins_in)));
                // 处理每个商户的数据
                $merchants_data[] = $merchant;
            }
        });
        return $merchants_data;
    }

    /**
     * @param array $data
     * @return Merchant
     * @throws Exception
     */
    public function createOrUpdateMchOne(array $data): Merchant
    {
        $merchant = new Merchant();
        $data['merchant_no'] = BaseData::makeMerchantNo($data['user_id']);
        $data['api_key'] = BaseData::makeKeyMd5($data['merchant_no']);
        if ($data['agent_rate_in'] ?? 0 and $data['agent_rate_out'] ?? 0) {
            $data['agent_rate_in'] = $data['agent_user_id'] ? $data['agent_rate_in'] : 0;
            $data['agent_rate_out'] = $data['agent_user_id'] ? $data['agent_rate_out'] : 0;
        }
        if ($id = ($data['id'] ?? 0)) {
            $result = $merchant->validate(Merchant::VALIDATE)->update($data, ['id' => $id]);
        } else {
            $result = $merchant->validate(Merchant::VALIDATE)->save($data);
        }
        if (false === $result) {
            // 验证失败 输出错误信息
            throw new Exception($merchant->getError());
        }
        $data = Merchant::get($merchant->id ?? $data['id']);
        unset($data->api_key);
        return $data;
    }

    /**
     * @param     $userId
     * @param int $rows
     * @param int $page
     * @param int $check_state
     * @return Paginator
     * @throws DbException
     */
    public function getMchList($userId, int $rows = 20, int $page = 1, $check_state = 999): \think\Paginator
    {
        $data = Merchant::order('id', 'desc')
            ->where(function ($query) use ($userId, $check_state) {
                if (User::get($userId)) {
                    $query->where('user_id', $userId);
                }
                if (!empty($check_state) and $check_state != 999) {
                    $query->where('check_state', $check_state);
                }
            })
            ->paginate($rows, false, [
                'page' => $page
            ]);;
        $data->each(function ($item) {
            $item->agent_user_text = $item->agent_user_id ? User::get($item->agent_user_id)->value('username') : null;
            $countrys = '';
            $coins_in = '';
            $coins_out = '';
            foreach ($item->countrys as $id) {
                $countrys .= SysCountryCoinsView::where('country_id', $id)->value('country_name') . '，';
            }
            foreach ($item->coins_in as $id) {
                $coins_in .= SysCountryCoinsView::where('currency_id', $id)->value('currency_name') . '，';
            }
            foreach ($item->coins_out as $id) {
                $coins_out .= SysCountryCoinsView::where('currency_id', $id)->value('currency_name') . '，';
            }
            $item->countrys_text = mb_substr($countrys, 0, -1);
            $item->coins_in_text = mb_substr($coins_in, 0, -1);
            $item->coins_out_text = mb_substr($coins_out, 0, -1);
            $item->product_type_id_text = SysOptionValue::getValue($item->product_type_id);
            $item->pay_way_id_text = SysOptionValue::getValue($item->pay_way_id);
            unset($item->api_key);
        });
        return $data;
    }

    /**
     * @param Merchant $merchant
     * @param string $key
     * @param          $value
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

    /**
     * @param Merchant $merchant
     * @param User $user
     * @param int $state
     * @param string|null $reason
     * @return bool
     */
    public function updateMchCheckState(Merchant $merchant, User $user, int $state, string $reason = null): bool
    {
        if ($merchant->id ?? 0 and $user->id ?? 0) {
            $merchant->check_user_id = $user->id;
            $merchant->check_time = date('Y-m-d H:i:s');
            $merchant->check_reason = $reason;
            $merchant->check_state = $state;
            $merchant->save();
            return true;
        }
        return false;
    }

    /**
     * @throws DbException
     */
    public function paymentTest()
    {
        $service = new PaymentService(Merchant::get(1));
        // bool
        $service->createOrderIn(PaymentService::PAY_NAME_PAYHAYU, '123',0.01, [
            'a'=>'b'
        ]);
        // $service->getStatus() > 1
        // $service->getMsg(); // string
         $result = $service->getResult(); // array 上游接口调用结果


    }
}