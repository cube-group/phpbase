<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Email
 * @package libs\Validate\rules
 */
class Email implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}是无效邮箱, 非法值{value}";
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
        return filter_var($value, \FILTER_VALIDATE_EMAIL) !== false;
    }
}
