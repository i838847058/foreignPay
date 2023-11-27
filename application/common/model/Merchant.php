<?php

namespace app\common\model;

use think\Model;

class Merchant extends Model
{
    protected $field = ['user_id', 'merchant_name', 'country_id', 'merchant_type', 'agent_id', 'check_user_id', 'check_time', 'rate_in', 'rate_out', 'status'];

}
