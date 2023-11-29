<?php

namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    /**
     * @param $array
     */
    public function convertToFloat(&$array)
    {
        if (!empty($array)) {
            foreach ($array as &$value) {
                if (is_array($value)) {
                    $this->convertToFloat($value);
                } elseif (is_numeric($value)) {
                    $value = (float)$value;
                }
            }
        }
    }
}