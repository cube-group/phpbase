<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Numeric
 * @package libs\Validate\rules
 */
class Numeric implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}只能是数字";
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
        return is_numeric($value);
    }

}
