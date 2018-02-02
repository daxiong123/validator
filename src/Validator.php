<?php

namespace Aichong;

/**
 * Class Validator
 *
 * @package Aichong
 */
class Validator
{

    /**
     * 错误消息
     *
     * @var string
     */
    private $message = '';

    /**
     * 数据验证
     *
     * @param array $data
     * @param array $rule
     * @param array $message
     * @return bool
     */
    public function validate(array $data, array $rule, array $message)
    {
        foreach ($rule as $key => $val) {

            $temp = explode('|', $val);
            $params = $temp;

            foreach ($params as $value) {

                if (!array_key_exists($key, $rule)) {

                    continue;
                }

                $args = [$data[$key]];

                if (strpos($value, ':') !== false) {

                    $tmp = explode(':', $value);

                    $func = '_' . $tmp[0];
                    array_push($args, $tmp[1]);

                    unset($tmp);
                } else {

                    $func = '_' . $value;
                }

                $ret = call_user_func_array([$this, $func], $args);

                if ($ret === false) {

                    $this->message = vsprintf($message[$key], $args);

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 返回错误信息
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * 验证必填
     *
     * @param string $value
     * @return bool
     */
    private function _required($value)
    {
        return !empty($value) ? true : false;
    }

    /**
     * 等于
     *
     * @param string $value
     * @param string $value1
     * @return bool
     */
    private function _equals($value, $value1)
    {
        return $value == $value1 ? true : false;
    }

    /**
     * 长度
     *
     * @param mixed $value
     * @param int   $length
     * @return bool
     */
    private function _length($value, $length)
    {
        return strlen($value) == (int)$length ? true : false;
    }

    /**
     * 验证URL
     *
     * @param string $value
     * @return bool
     */
    private function _url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false ? true : false;
    }

    /**
     * 验证最小值
     *
     * @param mixed $value
     * @param int   $length
     * @return bool
     */
    private function _min($value, $length)
    {
        if (is_int($value)) {

            return $value >= (int)$length ? true : false;
        } else {

            return strlen($value) >= (int)$length ? true : false;
        }
    }

    /**
     * 验证最大值
     *
     * @param mixed $value
     * @param int   $length
     * @return bool
     */
    private function _max($value, $length)
    {
        if (is_int($value)) {

            return $value <= (int)$length ? true : false;
        } else {

            return strlen($value) <= (int)$length ? true : false;
        }
    }

    /**
     * 验证IPv4地址
     *
     * @param string $value
     * @return bool
     */
    private function _ip($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false ? true : false;
    }

    /**
     * 验证邮箱
     *
     * @param string $value
     * @return bool
     */
    private function _email($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false ? true : false;
    }

    /**
     * 验证手机号码
     *
     * @param string $value
     * @return bool
     */
    private function _phone($value)
    {
        return preg_match('#(13\d|14[579]|15[^4\D]|17[^49\D]|18\d|19\d)\d{8}#', $value) ? true : false;
    }

    /**
     * 验证座机号码
     *
     * @param string $value
     * @return bool
     */
    private function _tel($value)
    {
        return preg_match('#(0[0-9]{2,3}-)?[2-9][0-9]{6,7}#', $value) ? true : false;
    }

    /**
     * 验证身份证号码
     *
     * @param string $value
     * @return bool
     */
    private function _id_card($value)
    {
        // 只能是18位
        if (strlen($value) != 18) {

            return false;
        }

        // 取出本体码
        $idcard_base = substr($value, 0, 17);

        // 取出校验码
        $verify_code = substr($value, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for ($i = 0; $i < 17; $i++) {

            $total += substr($idcard_base, $i, 1) * $factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        return $verify_code == $verify_code_list[$mod] ? true : false;
    }

    /**
     * 验证JSON
     *
     * @param mixed $value
     * @return bool
     */
    private function _json($value)
    {
        json_decode($value);

        return json_last_error() === JSON_ERROR_NONE ? true : false;
    }
}
