<?php
// ╭───────────────────────────────────────────────────────────┐
// │ QPF Framework [Key Studio]
// │-----------------------------------------------------------│
// │ Copyright (c) 2016-2019 quiun.com All rights reserved.
// │-----------------------------------------------------------│
// │ Author: qiun <qiun@163.com>
// ╰───────────────────────────────────────────────────────────┘
namespace qpf\helper;

/**
 * 模拟数据生成器
 * @author qpfsoft
 */
class Moni
{
    /**
     * 生成随机字符串
     * ```
     * string(2); //oj
     * string('1-4'); // o, ed, sdf, 4agu
     * string([1, 4]);
     * string(4, 'abcdefg'); // aegd
     * ```
     * @param mixed $rule 字符数
     * @param string $seed 自定义种子
     * @return string
     */
    public static function string($rule, $seed = null)
    {
        $chars = $seed ?: self::buildStrData(true, true, false);
        
        if (is_numeric($rule)) {
            return self::length($rule, $chars);
        }
        
        list($min, $max) = self::parseRule($rule);
        
        if ($max > strlen($chars) - 1) {
            $chars = str_pad($chars, $max, $chars);
        }
        
        return substr(str_shuffle($chars), 0, mt_rand(max(1, $min), $max));
    }
    
    /**
     * 生成随机数字
     * @param mixed $rule 位数, `length|min-max`
     * @param string $seed 自定义种子
     * @return int
     */
    public static function number($rule, $seed = null)
    {
        $chars = $seed ?: '0123456789';
        
        if (is_numeric($rule)) {
            return (int) self::length($rule, $chars);
        }
        
        list($min, $max) = self::parseRule($rule);
        
        return (int) mt_rand(max(1, $min), $max);
    }
    
    /**
     * 生成浮点数
     * @param mixed $intRule 整数部分规则 `length|min-max`
     * @param mixed $tinyRule 小数部分规则 `length|min-max`
     * @return float
     */
    public static function float($intRule, $tinyRule)
    {
        return (float) self::number($intRule) . '.' . self::number($tinyRule);
    }
    
    /**
     * 生成随机布尔值
     * @param bool $rule 手动指定
     * @return bool
     */
    public static function boolean($rule = null)
    {
        if (null === $rule) {
            return (bool) mt_rand(0, 1);
        }
        
        return (bool) $rule;
    }
    
    /**
     * 生成更多的True值
     * @param int $rule 100 - 90 = 10%的几率会false
     * @return boolean
     */
    public static function booleanTrue($rule = 90)
    {
        return mt_rand(1, 100) < $rule;
    }
    
    /**
     * 生成更多的False值
     * @param int $rule 100 - 90 = 10%的几率会true
     * @return boolean
     */
    public static function booleanFalse($rule = 90)
    {
        return mt_rand(1, 100) > $rule;
    }
    
    /**
     * 随机多个元素的值
     * @param array $array 数组数据
     * @param int $rule 返回元素数量`length|min-max`
     * @return array
     */
    public static function arr($array, $rule)
    {
        $max_key = count($array) - 1;
        
        $num = is_numeric($rule) ? $rule : self::number($rule);
        
        $rand_value = [];
        for ($i = 0; $i < $num; $i++) {
            $rand_value[] = $array[mt_rand(0, $max_key)];
        }
        return $rand_value;
    }
    
    /**
     * 随机一个数组的值
     * @param array $array
     * @return string
     */
    public static function arrVal(array $array)
    {
        return $array[array_rand($array)];
    }
    
    /**
     * 随机一个数组的键名
     * @param array $array
     * @return mixed
     */
    public static function arrKey(array $array)
    {
        return array_rand($array);
    }
    
    /**
     * 随机日期
     *
     * 取值范围`1~99`
     * @param string|array $rule 规则`Y-m-d`, `[Y, m, d]`
     * @return string
     */
    public static function date($rule)
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $y = is_numeric($y) ? $y : self::number($y);
        $m = min(is_numeric($m) ? $m : self::number($m), 99);
        $d = min(is_numeric($d) ? $d : self::number($d), 99);
        
        return \DateTime::createFromFormat('Y-m-d', "$y-$m-$d")->format('Y-m-d');
    }
    
    /**
     * 随机递增日期 - 天数
     * @param string $rule 日期`Y-m-d`
     * @param int $num 生成数量
     * @param string $incRule 递增规则, 'int'固定间隔值, 'min-max'随机间隔值
     * @return array
     */
    public static function dateIncrement($rule, $num , $incRule = '1-2')
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $result = [];
        $isNum = is_numeric($incRule);
        $date = date_create("$y-$m-$d");
        $inc = $isNum ? $incRule : self::number($incRule);
        
        for ($i = 0; $i < $num; $i++) {
            date_add($date, date_interval_create_from_date_string(intval($inc).' day'));
            $result[] = date_format($date, 'Y-m-d');
        }
        
        return $result;
    }
    
    /**
     * 日期递减
     * @param string $rule 日期`Y-m-d`
     * @param int $num 生成数量
     * @param string $incRule 递增规则, 'int'固定间隔值, 'min-max'随机间隔值
     * @return array
     */
    public static function dateDecrement($rule, $num , $incRule = '1-2')
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $result = [];
        $isNum = is_numeric($incRule);
        $date = date_create("$y-$m-$d");
        $inc = $isNum ? $incRule : self::number($incRule);
        
        for ($i = 0; $i < $num; $i++) {
            date_add($date, date_interval_create_from_date_string('- '. intval($inc) .' day'));
            $result[] = date_format($date, 'Y-m-d');
        }
        
        return $result;
    }
    
    /**
     * 随机时间
     * @param string $rule
     * @return string
     */
    public static function time()
    {
        $h = mt_rand(1, 12);
        $i = mt_rand(0, 59);
        $s = mt_rand(0, 59);
        
        $date = date_create("1999-1-1 $h:$i:$s");
        
        date_add($date, date_interval_create_from_date_string('+ '. intval($h) .' hours'));
        date_add($date, date_interval_create_from_date_string('+ '. intval($i) .' minutes'));
        date_add($date, date_interval_create_from_date_string('+ '. intval($s) .' seconds'));
        
        return date_format($date, 'H:i:s');
    }
    
    /**
     * 生成随机日期时间
     * @param mixed $rule 日期规则
     * @return string
     */
    public static function datetime($rule)
    {
        return self::date($rule) . ' ' . self::time();
    }
    
    /**
     * 生成随机汉字
     * @param int $num 汉字数量规则, `length|minLength-maxLength`
     * @param string $charset 字符集
     * @return string
     */
    public static function chinese($rule, $charset = 'utf-8')
    {
        if (is_numeric($rule)) {
            $num = $rule;
        } else {
            list($min, $max) = self::parseRule($rule);
            $num = mt_rand($min, $max);
        }
        
        return join('', self::buildStrChinese($num, $charset));
    }
    
    /**
     * 解析随机规则
     * ```
     * '1-4' => [1, 4]
     * ```
     * @param string|array $rule 规则
     * @param int $num 分割数量, 默认`2`
     * @return array
     */
    private static function parseRule($rule, $num = 2)
    {
        if (!is_array($rule)) {
            $rule = explode('-', $rule, $num);
        }
        
        return $rule;
    }
    
    /**
     * 生成指定长度的随机字符串
     * @param int $length 生成长度
     * @param string $chars 字符种子
     * @return string
     */
    private static function length($length, $chars)
    {
        $length = max(1, $length); // 最小1位
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $result;
    }
    
    /**
     * 使用规则生成
     *
     * ```
     * useRuleBuild(1);
     * useRuleBuild('1-4');
     * useRuleBuild([1, 4]);
     * useRuleBuild(1, 'abc');
     * ```
     * @param mixed $rule 规则`length|minLength-maxLength`
     * @param string $chars 字符种子
     * @return mixed
     */
    private static function useRuleBuild($rule, $chars)
    {
        if (is_numeric($rule)) {
            $rule = max(1, $rule);
            $result = '';
            for ($i = 0; $i < $rule; $i++) {
                $result .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            return $result;
        }
        
        if (!is_array($rule)) {
            $rule = explode('-', $rule, 2);
        }
        
        list($min, $max) = $rule;
        
        if ($max > strlen($chars) - 1) {
            $chars = str_pad($chars, $max, $chars);
        }
        
        return substr(str_shuffle($chars), 0, mt_rand(max(1, $min), $max));
    }
    
    /**
     * 获取字符串种子数据
     * @param bool $upper 是否包含大写字母
     * @param bool $number 是否包含数字
     * @param bool $rand 是否打乱顺序
     * @return string
     */
    public static function buildStrData($upper = true, $number = true, $rand = false)
    {
        $data = 'abcdefghijklmnopqrstuvwxyz';
        $data .= $upper ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '';
        $data .= $number ? '1234567890' : '';
        
        return $rand ? str_shuffle($data) : $data;
    }
    
    /**
     * 获取随机汉字
     * @param int $num 获取数量
     * @param string $charset 字符集
     * @return array 返回指定数量的汉字数组
     */
    public static function buildStrChinese($num, $charset = 'utf-8')
    {
        $result = [];
        for ($i = 0; $i < $num; $i ++) {
            $result[] = iconv('GB2312', $charset, chr(mt_rand(0xB0, 0xD0)) . chr(mt_rand(0xA1, 0xF0)));
        }
        
        return $result;
    }
}