<?php

namespace libs\Validate\rules;

use libs\Validate\LValidator;
use libs\Validate\Rule;

/**
 * Class Required
 * @package libs\Validate\rules
 */
class Required implements Rule
{
    /**
     * @return string
     */
    public static function message()
    {
        return '{field}不能为空';
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
        if (isset($params['skipEmpty']) && $params['skipEmpty']) {
            $attributes = $validator->attributes;
            if (isset($attributes[$field])) {
                return true;
            }
        }
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        }

        return true;
    }
}
