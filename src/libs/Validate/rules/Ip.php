<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Ip
 * @package libs\Validate\rules
 */
class Ip implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}是无效IP地址";
    }

    /**
     * @param $field
     * @param $value
     * @param array $params
     * @param LValidator $validator
     * @return bool
     */
    public static function validate($field, $value, $params = [], LValidator $validator)
    {
        return filter_var($value, \FILTER_VALIDATE_IP) !== false;
    }
}
