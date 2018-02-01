<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Contains
 * @package libs\Validate\rules
 */
class Contains implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}必须包含%s, 非法值{value}";
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
        if (!isset($params[0])) {
            return false;
        }
        if (!is_string($params[0]) || !is_string($value)) {
            return false;
        }

        $strict = true;
        if (isset($params[1])) {
            $strict = (bool)$params[1];
        }

        if ($strict) {
            return mb_strpos($value, $params[0]) !== false;
        } else {
            return mb_stripos($value, $params[0]) !== false;
        }
    }
}
