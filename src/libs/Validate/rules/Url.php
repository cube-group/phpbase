<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Url
 * @package libs\Validate\rules
 */
class Url implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return "{field}是无效的URL,非法值{value}";
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
        $value = trim($value);
        $validUrlPrefixes = ['http://', 'https://', 'ftp://'];
        foreach ($validUrlPrefixes as $prefix) {
            if (strpos($value, $prefix) !== false) {
                return filter_var($value, \FILTER_VALIDATE_URL) !== false;
            }
        }
        return false;
    }
}
