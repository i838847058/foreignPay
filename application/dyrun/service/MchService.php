<?php

namespace app\dyrun\service;

use app\admin\model\User;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;

class MchService
{
    /**
     * @param string $account_text
     * @return bool|\PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function getMchAccountList(string $account_text)
    {
        return User::field('id,username')->select(function ($query) use ($account_text) {
            $query->where('status', 'normal');
            $query->where('username', 'like', $account_text . '%');
        });
    }
}