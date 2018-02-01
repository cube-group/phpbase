<?php

namespace libs\Validate;

/**
 * Interface Rule
 * @author chenqionghe
 * @package libs\Validate\rules
 */
interface Rule
{
    /**
     * 消息模板
     *
     * @return mixed
     */
    public static function message();

    /**
     * 验证方法
     *
     * @param $field
     * @param $value
     * @param array $params
     * @param LValidator $validator
     * @return mixed
     */
    public static function validate($field, $value, $params = [], LValidator $validator);
}
