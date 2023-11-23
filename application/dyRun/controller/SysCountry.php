<?php

namespace app\dyRun\controller;

use app\common\controller\Api;
use app\common\model\SysCountry as SysCountryModel;
use think\Cache;

/**
 * 基础数据-国家管理
 */
class SysCountry extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';


    /**
     * 获取国家列表
     * @ApiSummary  (dyrun/sys_country/getSysCountryList)
     * @ApiHeaders  (name=token, type=string, required=true, description="请求的Token")
     * @ApiMethod (GET)
     * @ApiBody ({
    'id': 1,
    'name': '中文名字',
    })
     * @param string $name  中文名字
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     * 这样的操作对于大量数据是非常低效的，但是在数据量小的情况下可以使用。
     */
    public function getSysCountryList()
    {
        $params = $this->request->get();
        try {
            $redis = Cache::store('redis')->handler();
            // 删除这个键值对
            // $redis->del('sys_country');
            if (!$redis->exists('sys_country')) {
                $datas = SysCountryModel::getSysCountryList();
                foreach ($datas as $id => $name) {
                    $redis->hSet('sys_country', $id, $name);
                }
            }
            if (isset($params['name'])) {
                // 获取所有国家
                $countries = $redis->hGetAll('sys_country');
                // 模糊匹配
                $search = $params['name'];
                $list   = array_filter($countries, function ($key) use ($search) {
                    return strpos($key, $search) !== false;
                });
            } else {
                $list = $redis->hgetall('sys_country');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $list);
    }


}
