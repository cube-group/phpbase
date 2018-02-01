<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Integer
 * @package libs\Validate\rules
 */
class Integer implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}只能是整数(0-9)";
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
        if (isset($params[0]) && (bool)$params[0]) {
            return preg_match('/^-?([0-9])+$/i', $value);
        }
        return filter_var($value, \FILTER_VALIDATE_INT) !== false;
    }
}
