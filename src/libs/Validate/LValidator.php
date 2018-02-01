<?php

namespace libs\Validate;

use DateTime;
use libs\Orm\ArrayTrait;
use libs\Utils\Arrays;
use libs\Utils\Strings;
use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use libs\Validate\rules\Alpha;
use libs\Validate\rules\AlphaNum;
use libs\Validate\rules\BankCard;
use libs\Validate\rules\CarPlate;
use libs\Validate\rules\Date;
use libs\Validate\rules\Email;
use libs\Validate\rules\Ip;
use libs\Validate\rules\Slug;
use libs\Validate\rules\Tel;
use libs\Validate\rules\Url;
use Serializable;
use Countable;

/**
 * Class LValidator
 * @author chenqionghe
 * @property $attributes
 * @package libs\Validate
 * */
class LValidator implements ArrayAccess, IteratorAggregate, JsonSerializable, Serializable, Countable
{
    use ArrayTrait;

    /**
     * @var LValidator
     */
    private static $instance;

    /**
     * 错误消息
     *
     * @var array
     */
    private $_errors = [];

    /**
     * 验证规则集合
     *
     * @var array
     */
    private $_validations = [];

    /**
     * 字段映射标签
     *
     * @var array
     */
    private $_labels = [];


    /**
     * 验证的数据
     *
     * LValidator constructor.
     * @param array $data
     * @param array $labels
     */
    public function __construct($data = [], $labels = [])
    {
        if (is_string($data) || empty($data)) {
            $data = [];
        }
        $this->_attributes = $data;
        $this->_labels = $labels;
    }

    /**
     * 添加验证规则
     *
     * @param $params
     * @return $this
     */
    public function rule(array $params)
    {
        if (isset($params['message'])) {
            $message = $params['message'];
            unset($params['message']);
        } else {
            $message = static::getRuleMessage($params[0]);
        }
        $this->_validations[] = [
            'rule' => $params[0],
            'attributes' => (array)$params[1],
            'params' => array_slice($params, 2),
            'message' => $message
        ];
        return $this;
    }

    /**
     * 批量添加验证规则
     *
     * @param array $rules
     * @return $this
     */
    public function rules(array $rules)
    {
        foreach ($rules as $rule) {
            $this->rule($rule);
        }
        return $this;
    }

    /**
     * 为最近添加的验证规则设置错误消息
     *
     * @param  string $msg
     * @return $this
     */
    public function message($msg)
    {
        $this->_validations[count($this->_validations) - 1]['message'] = $msg;
        return $this;
    }

    /**
     * 为最近添加的验证规则设置映射标签
     *
     * @param $value
     * @return $this
     */
    public function label($value)
    {
        $lastRules = $this->_validations[count($this->_validations) - 1]['attributes'];
        $this->labels([$lastRules[0] => $value]);
        return $this;
    }

    /**
     * 批量设置字段映射标签
     *
     * @param array $labels
     * @return $this
     */
    public function labels($labels = [])
    {
        $this->_labels = array_merge($this->_labels, $labels);
        return $this;
    }

    /**
     * 执行验证
     *
     * @return bool
     */
    public function validate()
    {
        foreach ($this->_validations as $v) {
            foreach ($v['attributes'] as $field) {
                list($values, $multiple) = $this->getPart($this->attributes, explode('.', $field));
                // 如果字段没有指定required规则, 或者为空, 不验证
                if ($v['rule'] !== 'required' && !$this->hasRule('required', $field) && (!isset($values) || $values === '' || ($multiple && count($values) == 0))) {
                    continue;
                }
                $callback = static::getRuleCallback($v['rule']);
                if (!$multiple) {
                    $values = [$values];
                }
                $result = true;
                foreach ($values as $value) {
                    $result = $result && call_user_func($callback, $field, $value, $v['params'], $this);
                }
                if (!$result) {
                    $this->addError($field, $v['message'], $v['params']);
                }
            }
        }
        return count($this->errors()) === 0;
    }

    /**
     * 获取字段错误
     *
     * @param null $field
     * @return array|bool|mixed
     */
    public function errors($field = null)
    {
        if ($field !== null) {
            return isset($this->_errors[$field]) ? $this->_errors[$field] : false;
        }

        return $this->_errors;
    }


    /**
     * 获取字段第一个错误
     *
     * @param null $field
     * @return array|bool|mixed
     */
    public function errorString($field = null)
    {
        $res = [];
        $errors = $this->errors();
        foreach ($errors as $k => $v) {
            $res[$k] = implode(',', $v);
        }
        if (!empty($field)) {
            return Arrays::get($res, $field, '');
        }

        return implode('|', $res);
    }


    /**
     * 获取验证规则类
     *
     * @param $rule
     * @return string
     * @throws \Exception
     */
    public static function getRuleClass($rule)
    {
        $class = __NAMESPACE__ . '\\rules\\' . ucfirst($rule);
        if (!class_exists($class)) {
            throw new \Exception("{$class} not exist");
        }
        return $class;
    }

    /**
     * 获取验证规则回调
     *
     * @param $rule
     * @return mixed
     */
    public static function getRuleCallback($rule)
    {
        if ($rule instanceof \Closure) {
            return $rule;
        }
        $class = self::getRuleClass($rule);
        return [$class, 'validate'];
    }

    /**
     * 获取验证规则默认提示信息
     *
     * @param $rule
     * @return mixed
     */
    public static function getRuleMessage($rule)
    {
        if ($rule instanceof \Closure) {
            return "{field}无效";
        }
        $class = self::getRuleClass($rule);
        return call_user_func([$class, 'message']);
    }

    /**
     * 添加错误消息
     *
     * @param $field
     * @param $msg
     * @param array $params
     */
    public function addError($field, $msg, $params = [])
    {
        $msg = $this->formatMessage($field, $msg, $params);
        $values = [];
        foreach ($params as $param) {
            if (is_array($param)) {
                $param = "['" . implode("', '", $param) . "']";
            }
            if ($param instanceof DateTime) {
                $param = $param->format('Y-m-d');
            } else {
                if (is_object($param)) {
                    $param = get_class($param);
                }
            }
            if (isset($params[0]) && is_string($params[0])) {
                if (isset($this->_labels[$param])) {
                    $param = $this->_labels[$param];
                }
            }
            $values[] = $param;
        }
        $this->_errors[$field][] = vsprintf($msg, $values);
    }

    /**
     * @param $data
     * @param $identifiers
     * @return array
     */
    private function getPart($data, $identifiers)
    {
        if (is_array($identifiers) && count($identifiers) === 0) {
            return [$data, false];
        }
        $identifier = array_shift($identifiers);
        // *号匹配数组
        if ($identifier === '*') {
            $values = [];
            foreach ($data as $row) {
                list($value, $multiple) = $this->getPart($row, $identifiers);
                if ($multiple) {
                    $values = array_merge($values, $value);
                } else {
                    $values[] = $value;
                }
            }
            return [$values, true];
        } elseif ($identifier === NULL || !isset($data[$identifier])) {
            return [null, false];
        } // 匹配数组元素
        elseif (count($identifiers) === 0) {
            return [$data[$identifier], false];
        } else {
            return $this->getPart($data[$identifier], $identifiers);
        }
    }

    /**
     * 确定某个字段是否定义了该验证规则
     *
     * @param  string $name The name of the rule
     * @param  string $field The name of the field
     * @return boolean
     */
    private function hasRule($name, $field)
    {
        foreach ($this->_validations as $validation) {
            if ($validation['rule'] == $name) {
                if (in_array($field, $validation['attributes'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 格式化提示信息
     *
     * @param $field
     * @param $msg
     * @param $params
     * @return mixed
     */
    private function formatMessage($field, $msg, $params)
    {
        if (isset($this->attributes[$field])) {
            $msg = str_replace('{value}', $this->attributes[$field], $msg);
        }
        if (isset($this->_labels[$field])) {
            $msg = str_replace('{field}', $this->_labels[$field], $msg);
            if (is_array($params)) {
                $i = 1;
                foreach ($params as $k => $v) {
                    $tag = '{field' . $i . '}';
                    $label = isset($params[$k]) && (is_numeric($params[$k]) || is_string($params[$k])) && isset($this->_labels[$params[$k]]) ? $this->_labels[$params[$k]] : $tag;
                    $msg = str_replace($tag, $label, $msg);
                    $i++;
                }
            }
        } else {
            $msg = str_replace('{field}', Strings::case2camel($field), $msg);
        }
        return $msg;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }


    /**
     * @param array $data
     * @param array $labels
     * @return LValidator
     */
    public static function getInstance($data = [], $labels = [])
    {
        if (self::$instance == null) {
            self::$instance = new self($data, $labels);
        } else {
            self::$instance->reset($data, $labels);
        }
        return self::$instance;
    }

    /**
     * 重置对象
     *
     * @param array $data
     * @param array $labels
     * @return $this
     */
    public function reset($data = [], $labels = [])
    {
        $this->_attributes = $data;
        $this->_labels = $labels;
        $this->_errors = [];
        $this->_validations = [];
        return $this;
    }

    /**
     * 快速验证一个规则
     *
     * @param $rule
     * @return bool
     */
    public function validateRule($rule)
    {
        return $this->rule($rule)->validate();
    }

    /**
     * 快速验证多个规则
     *
     * @param $rules
     * @return bool
     */
    public function validateRules($rules)
    {
        return $this->rules($rules)->validate();
    }


    /********************************************** 以下是单个验证 **********************************************
     *
     * 判断是否是地址
     *
     * @param $value
     * @return bool
     */
    public static function isUrl($value)
    {
        return Url::validate('', $value, [], self::getInstance());
    }


    /**
     * 判断是否是邮箱
     *
     * @param $value
     * @return bool
     */
    public static function isEmail($value)
    {
        return Email::validate('', $value, [], self::getInstance());
    }

    /**
     * 是否是IP
     *
     * @param $value
     * @return bool
     */
    public static function isIp($value)
    {
        return Ip::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证英文字母
     *
     * @param $value
     * @return mixed
     */
    public static function isAlpha($value)
    {
        return Alpha::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证英文字母+数字
     *
     * @param $value
     * @return mixed
     */
    public static function isAlphaNum($value)
    {
        return AlphaNum::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证英文字母+数字+破折号+下划线
     *
     * @param $value
     * @return mixed
     */
    public static function isSlug($value)
    {
        return Slug::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证日期格式
     *
     * @param $value
     * @return mixed
     */
    public static function isDate($value)
    {
        return Date::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证合法的大陆电话号码
     *
     * @param $value
     * @return mixed
     */
    public static function isTel($value)
    {
        return Tel::validate('', $value, [], self::getInstance());
    }

    /**
     * 验证合法的大陆车牌号
     *
     * @param $value
     * @return mixed
     */
    public static function isCarPlate($value)
    {
        return CarPlate::validate('', $value, [], self::getInstance());
    }

    /**
     * 检测是否是合法银行卡号
     *
     * @param $value
     * @return mixed
     */
    public static function isBankCard($value)
    {
        return BankCard::validate('', $value, [], self::getInstance());
    }
}