<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class CarPlate
 * @package libs\Validate\rules
 */
class CarPlate implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}非法";
    }

    /**
     * @param $field
     * @param $value
     * @param array $params
     * @param LValidator $validator
     * @return mixed
     */
    public static function validate($field, $value, $params = [], LValidator $validator)
    {
        return (bool)preg_match('/^[\x{4e00}-\x{9fa5}]{1}[a-zA-Z]{1}[a-zA-Z_0-9]{4}[a-zA-Z_0-9_\x{4e00}-\x{9fa5}]$/u', $value);
    }

}
