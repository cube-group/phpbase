<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class BankCard
 * @package libs\Validate\rules
 */
class BankCard implements Rule
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
        if (strlen($value) > 19 || strlen($value) < 12) return false;
        return !empty($value) ? preg_match('/^[0-9][0-9]{11}[0-9]*$/', $value) : false;
    }

}
