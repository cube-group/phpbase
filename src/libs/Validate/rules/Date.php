<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use DateTime;
use libs\Validate\Rule;

/**
 * Class Date
 * @package libs\Validate\rules
 */
class Date implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}是无效的日期格式";
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
        if ($value instanceof DateTime) {
            return true;
        }
        return strtotime($value) !== false;
    }

}
