<?php

namespace app\dyRun\controller;

use app\common\controller\Api;
use app\common\model\SysCountry as SysCountryModel;

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
    'name': '中文名字',
    'code': '简称',
    'en_name': '英文名字',
    'list_rows': 10,
    'page': 1,
    })
     * @param string $name  中文名字
     * @param string $code  简称
     * @param string $en_name  英文名字
     * @param int $list_rows  每页条数
     * @param int $page  页数
     * @ApiReturn ({
    'code':'1',
    'msg':'成功',
    'time':'1700547489',
    'data':null,
    })
     */
    public function getSysCountryList()
    {
        $params = $this->request->get();
        try {
            $datas = SysCountryModel::getSysCountryList($params);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $datas);
    }


}
